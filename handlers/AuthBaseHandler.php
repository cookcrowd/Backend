<?php
abstract class AuthBaseHandler extends BaseHandler {
  public static $users = array();

  /**
   * Performs a http auth check
   */
  public function isLoggedIn() {
    $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
    $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;
    
    if(! $user || ! $pass || ! isset(static::$users[$_SERVER['PHP_AUTH_USER']]) || static::$users[$_SERVER['PHP_AUTH_USER']] !== $pass) {
      header('WWW-Authenticate: Basic realm="Cookielicious Backend"');
      header('HTTP/1.0 401 Unauthorized');
        
      echo 'Authentication required';
      exit;
    }
  }
}