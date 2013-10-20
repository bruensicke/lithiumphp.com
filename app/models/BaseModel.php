<?php

namespace app\models;

class BaseModel extends \radium\models\BaseModel {

	/**
	 * Custom find query properties, indexed by name.
	 *
	 * @var array
	 */
	public $_finders = array(
		'latest' => array(
			'type' => 'first',
			'order' => array(
				'created' => 'DESC',
			)
		)
	);
}

?>