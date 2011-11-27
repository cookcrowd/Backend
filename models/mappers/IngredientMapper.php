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
	
	public function findById($id) {
		$sql = "
			SELECT `id`, `name`
			FROM `ingredients`
			WHERE `id` = :id
			LIMIT 1
		";
		
		$stmt = $this->_db->prepare($sql);
		$stmt->execute(array(':id' => $id));
		
		$ingredient = $stmt->fetch(PDO::FETCH_ASSOC);
		if(! empty($ingredient)) {
			$ingredient = $this->create($ingredient);
			
			return $ingredient;
		}
		
		return false;
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
	 * Search for ingredients by $term
	 * 
	 * @param string $term
	 */
	public function search($term) {
		$sql = "
			SELECT
				`id`, `name`
			FROM
				`ingredients`
			WHERE `name` LIKE :term
			ORDER BY `name`
		";
		/**
		 * @var PDOStatement $stmt
		 */
		$stmt = $this->_db->prepare($sql);
		$stmt->execute(array(':term' => "%{$term}%"));
		
		$ingredients = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($ingredients, $this->create($row));
		}
		
		return ! empty($ingredients) ? $ingredients : false;
	}
	
	/**
	 * 
	 */
	public function save(Ingredient $ingredient) {
		if($ingredient->getId() < 1) {
			return $this->insert($ingredient);
		}
		else {
			return $this->update($ingredient);
		}
	}
	
	/**
	 * Inserts a new ingredient into the database
	 * 
	 * @param Ingredient $ingredient
	 * @return int|false The newly inserted ingredients id or false on failure
	 */
	public function insert(Ingredient $ingredient) {
		$sql = '
			INSERT INTO `ingredients` (`name`)
			VALUES (:name)
		';
		
		$stmt = $this->_db->prepare($sql);
		if($stmt->execute(array(':name' => $ingredient->getName()))) {
			return $this->_db->lastInsertId();
		}
		
		return false;
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