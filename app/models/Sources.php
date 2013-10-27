<?php

namespace app\models;

use lithium\util\Set;

use app\extensions\data\Sources as CoreSources;

class Sources extends BaseModel {

	/**
	 * Custom type options
	 *
	 * @var array
	 */
	public static $_types = array(
		'documentation' => 'documentation',
		'library' => 'library',
	);

	/**
	 * Stores the data schema.
	 *
	 * @see lithium\data\source\MongoDb::$_schema
	 * @var array
	 */
	protected $_schema = array(
		'type' => array('type' => 'string', 'default' => 'documentation'),
		'url' => array('type' => 'string', 'null' => false),
		'path' => array('type' => 'string', 'default' => '/', 'null' => false),
		'description' => array('type' => 'string', 'null' => true),
	);

	/**
	 * Custom find query properties, indexed by name.
	 *
	 * @var array
	 */
	public $_finders = array(
		'manual' => array(
			'conditions' => array(
				'type' => 'manual',
			)
		),
		'docs' => array(
			'conditions' => array(
				'type' => 'documentation',
			)
		),
		'libraries' => array(
			'conditions' => array(
				'type' => 'library',
			)
		),
	);

	/**
	 * Criteria for data validation.
	 *
	 * @see lithium\data\Model::$validates
	 * @see lithium\util\Validator::check()
	 * @var array
	 */
	public $validates = array(
		'slug' => array(
			array('notEmpty', 'severity' => 'important', 'message' => 'Source must have a slug.'),
			array('slug', 'severity' => 'important', 'message' => 'Source slug must be valid.'),
		),
	);

	/**
	 * Default query parameters.
	 *
	 * @var array
	 */
	protected $_query = array(
		'order' => array(
			'order' => 'ASC',
			'name' => 'ASC',
		),
	);

	/**
	 * return files for that source.
	 *
	 * Paths are relative, starting from root of source.
	 *
	 * @see app\extensions\data\Sources
	 * @param object $entity current object instance
	 * @param string|array $extension only return files with these extensions
	 * @param array $options additional options
	 *        - `raw`: set to true, to return files directly via filesystem from repository-clone
	 *        - `nested`: set to true, to return files with a nested structure
	 * @return array returns all files as array
	 */
	public function files($entity, $extension = null, array $options = array()) {
		$defaults = array('raw' => false, 'nested' => false);
		$options += $defaults;
		if ($options['raw']) {
			return CoreSources::files($entity->slug, $extension, $options);
		}

		$conditions = array(
			'source' => $entity->slug,
			'extension' => $extension,
		);
		$files = Files::find('all', compact('conditions'));
		if (!$options['nested']) {
			return $files;
		}
		$files = $files->map(function($f){ return $f->name; }, array('collect' => false));
		$files = Sources::explodeTree($files);
		return $files;
	}

}

?>