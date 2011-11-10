<?php
namespace Cookielicious\Model;

use Zurv\Model\Mapper\Base as BaseMapper;
use Zurv\Registry;
use PDO;

require_once 'models/Recipie.php';

class RecipieMapper extends BaseMapper {
	protected $_db = null;
	
	public function __construct() {
		$this->_db = Registry::getInstance()->db;
	}
	
	/**
	 * Find a recipie by its id
	 * 
	 * @param int $id
	 * @return Recipie|false
	 */
	public function findById($id) {
		$sql = '
			SELECT `id`, `title`, `preparation_time`, `thumbnail`
			FROM `recipies`
			WHERE `id` = :id
		';
		$stmt = $this->_db->prepare($sql);
		
		$stmt->execute(array(':id' => $id));
		$recipie = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(! empty($recipie)) {
			$recipie = $this->create($recipie);
			
			// Fetch ingredients
			require_once 'models/mappers/StepMapper.php';
			$stepMapper = new StepMapper();
			$recipie->setSteps($stepMapper->findByRecipie($recipie));
			
			return $recipie;
		}
		
		// No recipie found
		return false;
	}
	
	/**
	 * Fetch all recipies
	 * 
	 * @return array
	 */
	public function fetchAll() {
		$stmt = $this->_db->query('SELECT * FROM `images` ORDER BY `date` DESC');
		
		$strips = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($strips, $this->create($row));
		}
		
		return $strips;
	}
	
	/**
	 * Search by ingredients
	 */
	public function findByIngredients(array $ingredients) {
		/**
		 * THE QUERY SHOULD LOOK LIKE
		 * SELECT
				recipies.id, recipies.title, recipies.preparation_time, recipies.thumbnail,
				(
					SELECT COUNT(DISTINCT `step_ingredients`.`ingredient_id`)
					FROM `steps`
					LEFT JOIN `step_ingredients` ON `step_ingredients`.`step_id` = `steps`.`id`
					WHERE `steps`.`recipie_id` = `recipies`.`id` AND `step_ingredients`.`ingredient_id` IN (1,2)
				) AS `ingredient_match`
			FROM recipies
			LEFT JOIN steps ON steps.recipie_id = recipies.id
			LEFT JOIN step_ingredients ON step_ingredients.step_id = steps.id
			WHERE step_ingredients.ingredient_id IN (1,2)
			GROUP BY recipies.id
			ORDER BY `ingredient_match` DESC
		 */
	}

	/**
	 * Saves a recipie to the database
	 * 
	 * @param Recipie $recipie
	 */
	public function save(Recipie $recipie) {
		if($recipie->getId() < 0) {
			$this->insert($recipie);
		}
		else {
			$this->update($recipie);
		}
	}
	
	/**
	 * Insert a new recipie to the database
	 * 
	 * @param Recipie $recipie
	 */
	public function insert($recipie) {
		$sql = '
			INSERT INTO `recipies`
			()
			VALUES ()
		';
		$stmt = $this->_db->prepare($sql);
		return $stmt->execute(
			array(
				// TODO: Set statement parameters
			)
		);
	}
	
	/**
	 * Update a recipie in the database
	 * 
	 * @param Recipie $recipie
	 */
	public function update($recipie) {
		$sql = '
			UPDATE `recipies`
			SET
				
		';
		$stmt = $this->_db->prepare($sql);
		return $stmt->execute(
			array(
				// TODO: Set statement parameters
			)
		);
	}
	
	/**
	 * Delete a recipie from the database
	 * 
	 * @param int $id
	 */
	public function delete($id) {
		$stmt = $this->_db->prepare('DELETE FROM `recipies` WHERE `id` = :id');
		return $stmt->execute(array(':id' => $id));
	}
	
	/**
	 * Create an new Recipie object
	 * 
	 * @param array $seed
	 */
	public function create($seed = array()) {
		return new Recipie($seed);
	}
}