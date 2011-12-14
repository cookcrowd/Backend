<?php
namespace Cookielicious\Model;

use Zurv\Model\Mapper\Base as BaseMapper;
use Zurv\Registry;
use PDO;

require_once 'models/Recipe.php';

class RecipeMapper extends BaseMapper {
	/**
	 * @var PDO
	 */
	protected $_db = null;
	
	public function __construct() {
		$this->_db = Registry::getInstance()->db;
	}
	
	/**
	 * Find a recipe by its id
	 * 
	 * @param int $id
	 * @return Recipe|false
	 */
	public function findById($id) {
		$sql = '
			SELECT `id`, `title`, `preparation_time`, `image`
			FROM `recipes`
			WHERE `id` = :id
		';
		$stmt = $this->_db->prepare($sql);
		
		$stmt->execute(array(':id' => $id));
		$recipe = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(! empty($recipe)) {
			$recipe = $this->create($recipe);
			
			// Fetch ingredients
			require_once 'models/mappers/StepMapper.php';
			$stepMapper = new StepMapper();
			$recipe->setSteps($stepMapper->findByRecipe($recipe));
			
			return $recipe;
		}
		
		// No recipe found
		return false;
	}
	
	/**
	 * Fetch all recipes
	 * 
	 * @return array
	 */
	public function fetchAll() {
		$stmt = $this->_db->query('SELECT * FROM `images` ORDER BY `date` DESC');
		
		$recipes = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($recipes, $this->create($row));
		}
		
		return $strips;
	}
	
	/**
	 * Search by ingredients
	 * 
	 * @param array $ingredients
	 * @return array|false 
	 */
	public function findByIngredients(array $ingredients) {
		// Repeat where condition for each ingredient
		$where = substr(
			str_repeat('`ingredients`.`name` LIKE ? OR ', count($ingredients)), // Repeat sql where condition for each ingredient
			0, // Start at string positon 0
			-4 // Cut trailing ' OR '
		);
		
		$sql = "
			SELECT
				`recipes`.`id`, `recipes`.`title`, `recipes`.`preparation_time`, `recipes`.`image`,
				(
					SELECT COUNT(DISTINCT `step_ingredients`.`ingredient_id`)
					FROM `steps`
					LEFT JOIN `step_ingredients` ON `step_ingredients`.`step_id` = `steps`.`id`
					WHERE `steps`.`recipe_id` = `recipes`.`id` AND `step_ingredients`.`ingredient_id` IN (
						SELECT `ingredients`.`id`
						FROM `ingredients`
						WHERE {$where}
					)
				) AS `ingredient_match`
			FROM `recipes`
			LEFT JOIN `steps` ON `steps`.`recipe_id` = `recipes`.`id`
			LEFT JOIN `step_ingredients` ON `step_ingredients`.`step_id` = `steps`.`id`
			WHERE `step_ingredients`.`ingredient_id` IN (
				SELECT `ingredients`.`id`
				FROM `ingredients`
				WHERE {$where}
			)
			GROUP BY `recipes`.`id`
			ORDER BY `ingredient_match` DESC
		";
		
		$stmt = $this->_db->prepare($sql);
		$stmt->execute(array_merge($ingredients, $ingredients));
		
		$recipes = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$recipe = $this->create($row);
					
			// Fetch ingredients
			require_once 'models/mappers/StepMapper.php';
			$stepMapper = new StepMapper();
			$recipe->setSteps($stepMapper->findByRecipe($recipe));
			
			array_push($recipes, $recipe);
		}
		
		return ! empty($recipes) ? $recipes : false;
	}
	
	/**
	* Count recipes by ingredients
	*
	* @param array $ingredients
	* @return int
	*/
	public function countByIngredients(array $ingredients) {
		// Repeat where condition for each ingredient
		$where = substr(
		str_repeat('`ingredients`.`name` LIKE ? OR ', count($ingredients)), // Repeat sql where condition for each ingredient
		0, // Start at string positon 0
		-4 // Cut trailing ' OR '
		);
	
		$sql = "
				SELECT
					COUNT(DISTINCT `recipes`.`id`) AS `count`
				FROM `recipes`
				LEFT JOIN `steps` ON `steps`.`recipe_id` = `recipes`.`id`
				LEFT JOIN `step_ingredients` ON `step_ingredients`.`step_id` = `steps`.`id`
				WHERE `step_ingredients`.`ingredient_id` IN (
					SELECT `ingredients`.`id`
					FROM `ingredients`
					WHERE {$where}
				)
			";

		$stmt = $this->_db->prepare($sql);
		$stmt->execute($ingredients);
	
		$count = $stmt->fetch(PDO::FETCH_ASSOC);
	
		return $count['count'];
	}

	/**
	 * Saves a recipe to the database
	 * 
	 * @param Recipe $recipe
	 */
	public function save(Recipe $recipe) {
		if($recipe->getId() < 0) {
			$this->insert($recipe);
		}
		else {
			$this->update($recipe);
		}
	}
	
	/**
	 * Insert a new recipe to the database
	 * 
	 * @param Recipe $recipe
	 */
	public function insert($recipe) {
		$this->_db->beginTransaction();
		
		try {
			$sql = '
				INSERT INTO `recipes` (`title`, `preparation_time`, `image`)
				VALUES (:title, :preparation_time, :image)
			';
			$stmt = $this->_db->prepare($sql);
			$stmt->execute(array(
				':title' => $recipe->getTitle(),
				':preparation_time' => $recipe->getPreparationTime(),
				':image' => $recipe->getImage()
			));
			
			$id = $this->_db->lastInsertId();
			
			foreach($recipe->getSteps() as $step) {
				$sql = '
					INSERT INTO `steps` (`recipe_id`, `title`, `description`, `duration`, `image`)
					VALUES (:recipe_id, :title, :description, :duration, :image)
				';
				$stmt = $this->_db->prepare($sql);
				$stmt->execute(array(
					':recipe_id' => $id,
					':title' => $step->getTitle(),
					':description' => $step->getDescription(),
					':duration' => $step->getDuration(),
					':image' => $step->getImage()
				));
				
				$currStepId = $this->_db->lastInsertId();
				foreach($step->getIngredients() as $ingredient) {
					$sql = '
						INSERT INTO `step_ingredients` (`step_id`, `ingredient_id`, `amount`, `unit`)
						VALUE (:step_id, :ingredient_id, :amount, :unit)
					';
					
					$stmt = $this->_db->prepare($sql);
					$stmt->execute(array(
						':step_id' => $currStepId,
						':ingredient_id' => $ingredient->getId(),
						':amount' => $ingredient->getAmount(),
						':unit' => $ingredient->getUnit()
					));
				}
			}
			
			$this->_db->commit();
		} catch(Exception $e) {
			$this->_db->rollBack();
		}
	}
	
	/**
	 * Update a recipe in the database
	 * 
	 * @param Recipe $recipe
	 */
	public function update($recipe) {
		$sql = '
			UPDATE `recipes`
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
	 * Delete a recipe from the database
	 * 
	 * @param int $id
	 */
	public function delete($id) {
		$stmt = $this->_db->prepare('DELETE FROM `recipes` WHERE `id` = :id');
		return $stmt->execute(array(':id' => $id));
	}
	
	/**
	 * Create an new Recipe object
	 * 
	 * @param array $seed
	 */
	public function create($seed = array()) {
		return new Recipe($seed);
	}
}