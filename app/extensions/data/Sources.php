<?php
/**
 * Lithiumphp: the most rad php framework
 *
 * @copyright     Copyright 2013, brünsicke.com GmbH (http://bruensicke.com)
 */

namespace app\extensions\data;

use radium\util\Neon;
use lithium\core\Libraries;

class Sources {

	public static $path = '/sources';

	public static function find() {
		$files = static::files();
		return array_map(function($file) {
			return basename($file);
		}, $files);
	}

	public static function files() {
		return glob(sprintf('%s/*', dirname(LITHIUM_APP_PATH) . static::$path));
	}

	public static function get($name) {
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
			);
		}
		if (!is_array($data)) {
			return false;
		}
		if (!isset($data['name'])) {
			$data['name'] = $name;
		}
		return $data;
	}

	public static function sync($name) {
		return static::updateCopy($name);
	}

	public static function updateCopy($name) {
		$config = static::get($name);
		if ($config === false) {
			return false;
		}
		$resources = Libraries::get(true, 'resources');
		$destination = sprintf('%s/tmp/repositories/%s', $resources, $config['name']);
		$log = sprintf('%s/tmp/logs/%s.log', $resources, $config['name']);
		$cmd = (is_dir($destination))
			// ? sprintf('cd %s && git clean && git pull >> %s 2>&1', $destination, $log)
			? sprintf('cd %s && git fetch origin && git reset --hard origin/master >> %s 2>&1', $destination, $log)
			: sprintf('git clone %s %s >> %s 2>&1', $config['url'], $destination, $log);
		$output = array();
		$code = null;
		exec($cmd, $output, $code);
		if ($code === 0) {
			return true;
		}
		return false;
	}

}

?>