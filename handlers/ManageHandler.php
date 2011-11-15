<?php

class ManageHandler extends BaseHandler {
	/**
	 * Permitted backend users
	 * @var array
	 */
	public static $users = array(
		'admin' => 'admin'
	);
	
	protected $_template = 'index.php';
	
	public function get() {
		$this->isLoggedIn();
		
		$this->_view->display();
	}
	
	public function post() {
		$this->isLoggedIn();
		
		
	}
	
	/**
	 * Performs a http auth check
	 */
	public function isLoggedIn() {
		$user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
		$pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;
		
		if(! $user || ! $pass || ! isset(self::$users[$_SERVER['PHP_AUTH_USER']]) || self::$users[$_SERVER['PHP_AUTH_USER']] !== $pass) {
			header('WWW-Authenticate: Basic realm="Cookielicious Backend"');
			header('HTTP/1.0 401 Unauthorized');
				
			echo 'Authentication required';
			exit;
		}
	}
}