<?php
use Zurv\View\View;
use Zurv\View\Adapter\Factory as AdapterFactory;

abstract class BaseHandler extends ToroHandler {
	protected $_db = null;
	
	/**
	 * @var \Zurv\View\View
	 */
	protected $_view = null;
	protected $_template = '';
	
	protected $_isAjax = false;
	
	public function __construct() {
		parent::__construct();

		$this->_db = Zurv\Registry::getInstance()->db;
		
		if(isset($this->_template)) {
			$this->_template = strpos($this->_template, '.') !== false ? "views/{$this->_template}" : "views/{$this->_template}.php";
		}
		
		$this->_view = new View();
	}
	
	public function ajax($isAjax = true) {
		$adapter = null;
		if($isAjax) {
			$adapter = AdapterFactory::create(AdapterFactory::JSON);
		}
		else {
			$adapter = AdapterFactory::create(AdapterFactory::FILE, $this->_template);
		}
		
		$this->_view->setAdapter($adapter);
	}
}