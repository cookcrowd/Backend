<?php
namespace Zurv;

/**
 * Basic registry.
 * 
 * @author mau
 *
 */
class Registry {
	private static $_instance = null;
	
	private $_data = array();
	
	/**
	 * Singleton.
	 */
	private final function __construct() {}
	private final function __clone() {}
	
	public static function getInstance() {
		if(self::$_instance === null) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Magically get class properties
	 * 
	 * @param mixed $key
	 */
	public function __get($key) {
		if(isset($this->_data[$key])) {
			return $this->_data[$key];
		}
		
		return null;
	}
	
	/**
	 * Magically set class properties
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set($key, $value) {
		$this->_data[$key] = $value;
	}
}


/**
 * Base model entities and base mappers.
 * 
 * @author mau
 */
namespace Zurv\Model;

interface Entity {
	/**
	 * Check, if an entity has a property
	 * 
	 * @param string $key
	 * @return bool
	 */
	function has($key);
	
	/**
	 * Convert the entity object to an associative array
	 * 
	 * @return array
	 */
	function toArray();
}

/**
 * Mapper interface
 */
interface Mapper {
	/**
	 * Find entity by id
	 * @param mixed $id
	 */
	function findById($id);
	
	/**
	 * Find entity by attribute
	 * 
	 * @param string $attribute
	 * @param mixed $value
	 */
	function findByAttribute($attribute, $value);
}

namespace Zurv\Model\Mapper;

/**
 * Base mapper
 * 
 * @author mau
 */
abstract class Base implements \Zurv\Model\Mapper {
	public function findById($id) {
		throw new Exception('To be implemented');
	}
	
	public function findByAttribute($attribute, $value) {
		throw new Exception('To be implemented');
	}
}


namespace Zurv\Model\Entity;

abstract class Base implements \Zurv\Model\Entity {
	protected $_attributes = array();
	
	/**
	 * Constructor.
	 * @param array $seed Optionally set the seed values
	 */
	public function __construct($seed = array()) {
		if(! empty($seed)) {
			$this->_setAttributes($seed);
		}
	}
	
	/**
	 * Convenience method for setting multiple attributes the same time
	 * @param array $attributes
	 */
	protected function _setAttributes($attributes) {
		foreach($attributes as $key => $value) {
			$this->{'set' . ucfirst($key)}($value);
		}
	}
	
	/**
	 * Returns the entity data as array
	 * 
	 * @return array
	 */
	public function toArray() {
		return $this->_attributes;
	}
	
	/**
	 * Magig getters and setters.
	 * @param string $method
	 * @param array $params
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $params) {
		$do = strtolower(substr($method, 0, 3));
		$var = substr($method, 3);
		$var = $this->_getKey($var);
		switch($do) {
			case 'get':
				return $this->_getAttribute($var);
				break;
			case 'set':
				if(empty($params)) {
					throw new \BadMethodCallException('Missing parameter to set');
				}
				
				$this->_setAttribute($var, array_pop($params));
				break;
			case 'is':
				return $this->_getAttribute($var) ? true : false;
				break;
			default:
				throw new \BadMethodCallException("Could not invoke method {$method}");
			break;
		}
	}
	
	/**
	 * Check for a given attribute.
	 * @param string $key
	 */
	public function has($key) {
		return array_key_exists($key, $this->_attributes);
	}
	
	/**
	 * Get class attribute.
	 * @param string $key
	 * @throws \BadMethodCallException
	 */
	protected function _getAttribute($key) {
		if(! $this->has($key)) {
			throw new \BadMethodCallException('Class' . __CLASS__ . ' has no attribute ' . $key);
		}
		
		return $this->_attributes[$key];
	}
	
	/**
	 * Set class attribute.
	 * @param string $key
	 * @param mixed $param
	 * @throws \BadMethodCallException
	 */
	protected function _setAttribute($key, $param) {
		if(! $this->has($key)) {
			throw new \BadMethodCallException('Class' . __CLASS__ . ' has no attribute ' . $key);
		}
		
		$this->_attributes[$key] = $param;
	}
	
	/**
	 * Convert a camel cased key to a underscored one. E.g. testKey converts to test_key
	 * 
	 * @param string $key
	 * @return string
	 */
	protected function _getKey($key) {
		return strtolower(substr(preg_replace('/([A-Z])/', '_\1', $key), 1));
	}
}

/**
 * Basic view.
 */
namespace Zurv\View;

interface Adapter {
	/**
	 * Render the view
	 * 
	 * @param array $vars
	 */
	function render(array $vars);
}

/**
 * Class for handling views
 * 
 * @author mau
 */
class View {
	/**
	 * @var array
	 */
	protected $_vars = array();
	
	/**
	 * @var ViewAdapter
	 */
	protected $_viewAdapter = null;
	
	public function __construct(Adapter $adapter = null) {
		$this->_viewAdapter = $adapter;
	}
	
	public function __get($key) {
		if(! array_key_exists($key, $this->_vars)) {
			return null;
		}
		
		return $this->_vars[$key];
	}
	
	public function __set($key, $value) {
		$this->_vars[$key] = $value;
	}
	
	public function render($vars = array()) {
		$vars = array_merge($this->_vars, $vars);
		
		$render = $this->_viewAdapter->render($vars);
		
		return $render;
	}
	
	public function display(array $vars = array()) {
		echo $this->render($vars);
	}
	
	public function getAdapter() {
		return $this->_viewAdapter;
	}
	
	public function setAdapter(\Zurv\View\Adapter $adapter) {
		$this->_viewAdapter = $adapter;
	}
	
	public function __toString() {
		return $this->render();
	}
}

namespace Zurv\View\Adapter;
/**
 * ViewAdapter for file templates
 * 
 * @author mau
 */
class FileView implements \Zurv\View\Adapter {
	protected $_template = '';
	
	public function __construct($file) {
		if(! file_exists($file)) {
			throw new \InvalidArgumentException("Could not load view {$view}");
		}
		
		$this->_template = $file;
	}
	
	public function render(array $vars) {
		header('Content-Type: text/html; charset="utf8"');
		
		ob_start();
		extract($vars);
		include $this->_view;
		$render = ob_get_contents();
		ob_end_clean();
		
		return $render;
	}
}

/**
 * ViewAdapter for json encoded requests
 * 
 * @author mau
 */
class JSONView implements \Zurv\View\Adapter {
	public function render(array $vars) {
		header('Content-Type: application/json; charset="utf8"');
		
		return json_encode($vars);
	}
}

/**
 * Factory for creating ViewAdapters
 * 
 * @author mau
 */
class Factory {
	const FILE = 'file';
	const JSON = 'json';
	
	public static function create() {
		$args = func_get_args();
		$adapter = null;
		
		$type = array_shift($args);
		switch($type) {
			case self::FILE:
				$adapter = new \ReflectionClass('FileView');
				$adapter = $adapter->newInstanceArgs($args);
				break;
			case self::JSON:
				$adapter = new JSONView();
				break;
			default:
				throw new \InvalidArgumentException("Could not load ViewAdapter for type {$type}");
				break;
 		}
 		
 		return $adapter;
	}
}