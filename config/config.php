<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

/**
 * Configuration
 */
define('ZURV_BASE_HREF', "http://{$_SERVER['HTTP_HOST']}:{$_SERVER['SERVER_PORT']}/cookielicious/");

define('ZURV_MYSQL_HOST', '127.0.0.1');
define('ZURV_MYSQL_PORT', '8889'); // defaults to 3306
define('ZURV_MYSQL_USER', 'root');
define('ZURV_MYSQL_PASS', 'root');
define('ZURV_MYSQL_DBNAME', 'cookielicious');
define('ZURV_MYSQL_ENCODING', 'utf8');

date_default_timezone_set('Europe/Berlin');

/**
 * Don't touch below here.
 */
Zurv\Registry::getInstance()->db = new PDO('mysql:host=' . ZURV_MYSQL_HOST . ';port=' . ZURV_MYSQL_PORT . ';dbname=' . ZURV_MYSQL_DBNAME . '', ZURV_MYSQL_USER, ZURV_MYSQL_PASS);
Zurv\Registry::getInstance()->db->query('SET NAMES "' . ZURV_MYSQL_ENCODING . '"');
Zurv\Registry::getInstance()->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);