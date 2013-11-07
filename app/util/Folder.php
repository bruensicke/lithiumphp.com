<?php

namespace app\util;

class Folder extends \lithium\core\Object {

	/**
	 * holds folder to retrieve files for
	 *
	 * @var string
	 */
	public $_folder = '';

	/**
	 * specifies if files need to be found recursively
	 *
	 * @var string
	 */
	public $_recursive = true;

	/**
	 * Holds an array of values that should be processed on initialization. Each value should have
	 * a matching protected property (prefixed with `_`) defined in the class. If the property is
	 * an array, the property name should be the key and the value should be `'merge'`. See the
	 * `_init()` method for more details.
	 *
	 * @see lithium\core\Object::_init()
	 * @var array
	 */
	protected $_autoConfig = array('folder', 'recursive');

	/**
	 * Initializes class configuration (`$_config`), and assigns object properties using the
	 * `_init()` method, unless otherwise specified by configuration. See below for details.
	 *
	 * @see lithium\core\Object::$_config
	 * @see lithium\core\Object::_init()
	 * @param array $config The configuration options which will be assigned to the `$_config`
	 *              property. This method accepts one configuration option:
	 *              - `'init'` _boolean_: Controls constructor behavior for calling the `_init()`
	 *                method. If `false`, the method is not called, otherwise it is. Defaults to
	 *                `true`.
	 */
	public function __construct(array $config = array()) {
		$defaults = array('folder' => '', 'recursive' => true);
		$this->_config = $config + $defaults;

		if ($this->_config['init']) {
			$this->_init();
		}
	}

	public function files($extension = null) {
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

}

?>