<?php
/**
 * Lithiumphp: central hub for lithium development
 *
 * @copyright     Copyright 2013, brünsicke.com GmbH (http://bruensicke.com)
 */

namespace app\extensions\data;

use app\models\Files as FilesModel;
use app\models\Sources as SourcesModel;

use radium\util\Neon;
use lithium\core\Libraries;

use FilesystemIterator;
use DirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Sources {

	/**
	 * defines, where to search for source-files
	 *
	 * @var string
	 */
	public static $path = '/sources';

	/**
	 * returns content of filename for a given source
	 *
	 * @param string $name name of source to retrieve file content for
	 * @param string $file filename to retrieve content for, relative to source root
	 * @return string content of requested file
	 */
	public static function file($name, $file) {
		$folder = static::folder($name);
		if ($folder === false) {
			return false;
		}

		return file_get_contents(sprintf('%s/%s', $folder, $file));
	}

	/**
	 * returns flat array of files, filtered by given extension (if given).
	 *
	 * @param string $name name of source to retrieve files for
	 * @param string|array $extension file-extensions to be returned
	 * @param array $options an array with additional options
	 *        - `nested`: if set to true, will return a nested array, instead of a flat one
	 * @return array an array containing strings with each relative path and filenames
	 */
	public static function files($name, $extension = null, array $options = array()) {
		$config = static::get($name);
		$defaults = array('nested' => false, 'subfolder' => $config['path']);
		$options += $defaults;
		$folder = static::folder($name, $options['subfolder']);

		if ($folder === false) {
			return array();
		}

		$files = array();

		$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
		$files = array();
		foreach ($it as $file) {

			if (!in_array($file->getExtension(), (array) $extension)) {
				continue;
			}
			if ($options['nested']) {
				$path = $file->isDir()
					? array($file->getFilename() => array())
					: array($file->getFilename());

				for ($depth = $it->getDepth() - 1; $depth >= 0; $depth--) {
					$path = array($it->getSubIterator($depth)->current()->getFilename() => $path);
				}
				$files = array_merge_recursive($files, $path);
			} else {
				if (!$file->isFile()) {
					continue;
				}
				$files[] = str_replace($folder, '', $file);
			}

		}
		// var_dump($files);exit;
		return $files;
	}

	/**
	 * returns configuration for a source, as configured in source-file
	 *
	 * @param string $name name of source to retrieve configuration for
	 * @return array all configuration data as associative array
	 */
	public static function get($name) {
		$defaults = array('name' => $name, 'path' => '/', 'type' => 'documentation');
		$path = dirname(LITHIUM_APP_PATH) . static::$path;
		$file = sprintf('%s/%s', $path, $name);
		if (!file_exists($file) || !is_readable($file)) {
			return false;
		}
		$content = file_get_contents($file);
		if (empty($content)) {
			return false;
		}
		$data = Neon::decode($content);
		if (is_string($data)) {
			return array(
				'name' => $name,
				'url' => $data,
				'path' => '/',
				'type' => 'documentation',
			);
		}
		if (!is_array($data)) {
			return false;
		}
		$data += $defaults;
		return $data;
	}

	/**
	 * returns folder for given source
	 *
	 * @param string $name name of source to retrieve folder for
	 * @return string the absolute path to the folder where cached source-files reside
	 */
	public static function folder($name, $subfolder = '/') {
		$config = static::get($name);
		if ($config === false) {
			return false;
		}
		$resources = Libraries::get(true, 'resources');
		$path = sprintf('%s/tmp/repositories/%s', $resources, $name);
		if ($subfolder === true) {
			$subfolder = $config['path'];
		}
		if ($subfolder == '/') {
			return $path;
		}
		return $path.$subfolder;
	}

	/**
	 * syncs the local copy of all files with remote repository and updates all
	 * local data in the database to reflect latest changes.
	 *
	 * @param string $name name of source to sync files and data for
	 * @return boolean true on success, false otherwise
	 */
	public static function sync($name) {
		$result = static::updateCopy($name);
		if ($result === false) {
			return false;
		}
		// $result = static::generateApidocs($name);
		// if ($result === false) {
		// 	return false;
		// }
		$result = static::importData($name);
		if ($result === false) {
			return false;
		}
		return true;
	}

	public static function generateApidocs($name) {
		$config = static::get($name);
		$folder = static::folder($name);
		$resources = Libraries::get(true, 'resources');
		$path = Libraries::get(true, 'path');
		$destination = sprintf('%s/webroot/api/%s', $path, $name);
		$log = sprintf('%s/tmp/logs/%s.log', $resources, $name);
		if (!is_dir($folder)) {
			return false;
		}
		// $cmd = sprintf('apigen -s %s -d %s >> %s 2>&1', $folder, $destination, $log);
		$cmd = sprintf('phpdoc -d %s -t %s >> %s 2>&1', $folder, $destination, $log);
		$output = array();
		$code = null;
		exec($cmd, $output, $code);
		if ($code === 0) {
			return true;
		}
		return false;
	}

	/**
	 * imports all relevant files into database
	 *
	 * @param string $name name of source to import file data for
	 * @return boolean true on success, false otherwise
	 */
	public static function importData($name) {
		$config = static::get($name);
		$source = SourcesModel::load($name);
		if (!$source) {
			$source = SourcesModel::create();
			$source->slug = $name;
		}
		$data = array(
			'name' => $source->name,
			'description' => $source->description,
			'path' => $source->path,
			'url' => $source->url,
		);
		$diff = array_diff($data, $config);
		if (!empty($diff)) {
			$source->set($config);
			$source->save();
		}

		$docs = static::files($name, array('md', 'markdown', 'php'));
		if ($docs === false) {
			return false;
		}
		if (empty($docs)) {
			return true;
		}
		foreach ($docs as $doc) {
			$id = sha1($name.$doc);
			$file = FilesModel::first($id);
			if (!$file) {
				$file = FilesModel::create();
				$file->source = $name;
				$data = array(
					'name' => $doc,
					'type' => (pathinfo($doc, PATHINFO_EXTENSION) == 'php') ? 'php' : 'markdown',
					'extension' => pathinfo($doc, PATHINFO_EXTENSION),
					'path' => dirname($doc),
					'filename' => basename($doc),
					// 'content' => static::file($doc),
				);
				$file->set($data);
				$file->save();
			}
			// echo $doc;
		}
		return true;
	}

	/**
	 * updates or creates local cached copy of remote repository
	 *
	 * @param string $name name of source to create/update local cache for
	 * @return boolean true on success, false otherwise
	 */
	public static function updateCopy($name) {
		$config = static::get($name);
		if ($config === false) {
			return false;
		}
		$destination = static::folder($name);
		$resources = Libraries::get(true, 'resources');
		$log = sprintf('%s/tmp/logs/%s.log', $resources, $name);
		$cmd = (is_dir($destination))
		/* ? sprintf('cd %s && git clean && git pull >> %s 2>&1', $destination, $log) */
		 ? sprintf('{ cd %s && git fetch origin && git reset --hard origin/master; } >> %s 2>&1'
			, $destination, $log)
		 : sprintf('git clone --recursive %s %s >> %s 2>&1', $config['url'], $destination, $log);
		$output = array();
		$code = null;
		exec($cmd, $output, $code);
		if ($code === 0) {
			return true;
		}
		return false;
	}

	/**
	 * returns all available sources
	 *
	 * @see  Sources::all()
	 * @return array an array containing all source-files available
	 */
	public static function find() {
		return static::all();
	}

	/**
	 * returns all available sources
	 *
	 * @see  Sources::find()
	 * @return array an array containing all source-files available
	 */
	public static function all() {
		$folder = dirname(LITHIUM_APP_PATH) . static::$path;
		$it = new DirectoryIterator($folder);
		$files = array();
		foreach ($it as $file) {
			if (!$it->isDot()) {
				$files[] = $file->getFilename();
			}
		}
		return $files;
	}
}

?>