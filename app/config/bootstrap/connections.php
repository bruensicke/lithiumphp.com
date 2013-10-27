<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\data\Connections;

Connections::add('default', array(
	'type' => 'MongoDb',
	'host' => 'localhost',
	'database' => 'lithiumphp'
));

?>