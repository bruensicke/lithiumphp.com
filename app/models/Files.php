<?php

namespace app\models;

use lithium\net\http\Router;

class Files extends BaseModel {

	/**
	 * Stores the data schema.
	 *
	 * @see lithium\data\source\MongoDb::$_schema
	 * @var array
	 */
	protected $_schema = array(
		'filename' => array('type' => 'string', 'null' => false),
		'extension' => array('type' => 'string', 'null' => false),
		'path' => array('type' => 'string', 'null' => false),
		'source' => array('type' => 'string', 'null' => false),
		'content' => array('type' => 'string', 'null' => false),
	);

	/**
	 * automatically sets primary key
	 *
	 * @see lithium\data\Model
	 * @param object $entity current instance
	 * @param array $data Any data that should be assigned to the record before it is saved.
	 * @param array $options additional options
	 * @return boolean true on success, false otherwise
	 * @filter
	 */
	public function save($entity, $data = array(), array $options = array()) {
		if (!empty($data)) {
			$entity->set($data);
		}
		if (empty($entity->source) || empty($entity->name)) {
			return false;
		}
		$entity->{static::key()} = sha1($entity->source.$entity->name);
		return parent::save($entity, null, $options);
	}

	public function url($entity) {
		return $entity->path;
		return sprintf('%s/docs/%s%s', Router::match('/'), $entity->source, $entity->path);
	}
}

?>