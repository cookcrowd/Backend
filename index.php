<?php
// Autoload toro handlers
function __autoload($class) {
	if(strpos($class, '\\') !== false) {
		$class = substr($class, strrpos($class, '\\') + 1);	
	}
	
	$classFile = "handlers/{$class}.php";
	if(strstr($class, 'Handler') && file_exists($classFile)) {
		require_once $classFile;
	}
}

require_once 'library/core.php';
require_once 'library/toro.php';
require_once 'config/config.php';

/**
 * Push put and delete request variables into $_POST.
 */
ToroHook::add('before_request', function() {
	$input = json_decode(file_get_contents('php://input'), true);
	switch(strtolower($_SERVER['REQUEST_METHOD'])) {
		case 'get':
		case 'post': break;
		case 'put': $_POST = $input; break;
		case 'delete': $_POST = $input; break;
		default: throw new Exception('Invalid request type'); break;
	}
	
});

/**
 * Close the database connection.
 */
ToroHook::add('after_request', function() {
	Zurv\Registry::getInstance()->db = null;
});


/**
 * Set routes.
 */
$site = new ToroApplication(array(
	array('/', 'AppHandler')
));

/**
 * Have fun with your application!
 */
$site->serve();