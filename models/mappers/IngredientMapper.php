<?php
namespace Cookielicious\Model;

use Zurv\Model\Mapper\Base as BaseMapper;
use Zurv\Registry;
use PDO;

require_once 'models/Ingredient.php';

class IngredientMapper extends BaseMapper {
	/**
	 * @var PDO
	 */
	protected $_db = null;
	
	public function __construct() {
		$this->_db = Registry::getInstance()->db;
	}
	
	/**
	 * Fetch all existing ingredients
	 * 
	 * @return array|false
	 */
	public function fetchAll() {
		$sql = "
			SELECT
				`id`, `name`
			FROM
				`ingredients`
			ORDER BY `name`
		";
		
		$stmt = $this->_db->query($sql); 
		
		$ingredients = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($ingredients, $this->create($row));
		}
		
		return ! empty($ingredients) ? $ingredients : false;
	}
	
	/**
	 * Create an new Ingredient object
	 * 
	 * @param array $seed
	 */
	public function create($seed = array()) {
		return new Ingredient($seed);
	}
}