<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

define('LITHIUM_APP_PATH', dirname(dirname(__DIR__)));
define('LITHIUM_LIBRARY_PATH', dirname(LITHIUM_APP_PATH) . '/libraries');
define('POSTS_PATH', dirname(LITHIUM_APP_PATH) . '/posts');

if (!include LITHIUM_LIBRARY_PATH . '/lithium/core/Libraries.php') {
	$message  = "Lithium core could not be found.  Check the value of LITHIUM_LIBRARY_PATH in ";
	$message .= __FILE__ . ".  It should point to the directory containing your ";
	$message .= "/libraries directory.";
	throw new ErrorException($message);
}

use lithium\core\Libraries;

require LITHIUM_LIBRARY_PATH . '/lithium/core/Object.php';
require LITHIUM_LIBRARY_PATH . '/lithium/core/StaticObject.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/Collection.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/collection/Filters.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/Inflector.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/String.php';
require LITHIUM_LIBRARY_PATH . '/lithium/core/Adaptable.php';
require LITHIUM_LIBRARY_PATH . '/lithium/core/Environment.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/Message.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Message.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Media.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Request.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Response.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Route.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Router.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Controller.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Dispatcher.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Request.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Response.php';
require LITHIUM_LIBRARY_PATH . '/lithium/template/View.php';
require LITHIUM_LIBRARY_PATH . '/lithium/template/view/Renderer.php';
require LITHIUM_LIBRARY_PATH . '/lithium/template/view/Compiler.php';
require LITHIUM_LIBRARY_PATH . '/lithium/template/view/adapter/File.php';
require LITHIUM_LIBRARY_PATH . '/lithium/storage/Cache.php';
require LITHIUM_LIBRARY_PATH . '/lithium/storage/cache/adapter/Apc.php';

Libraries::add('lithium');
Libraries::add('app', array('default' => true));

/**
 * Add some plugins:
 */
// Libraries::add('li3_docs');
Libraries::add('li3_quality');
Libraries::add('li3_mustache');
Libraries::add('radium');
Libraries::add('li3_markdown');

?>