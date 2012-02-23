<?php
namespace Cookielicious\Model;

use Zurv\Model\Mapper\Base as BaseMapper;
use Zurv\Registry;
use PDO;

require_once 'models/Step.php';
require_once 'models/Ingredient.php';
require_once 'models/Todo.php';

class StepMapper extends BaseMapper {
	/**
	 * @var PDO
	 */
	protected $_db = null;
	
	public function __construct() {
		$this->_db = Registry::getInstance()->db;
	}
	
	/**
	 * Find all steps for a recipe
	 * 
	 * @param Recipe|id $recipe
	 */
	public function findByRecipe(Recipe $recipe) {
		$sql = '
			SELECT
				`steps`.`id` AS `steps.id`,
				`steps`.`title` AS `steps.title`,
				`steps`.`description` AS `steps.description`,
				`steps`.`duration` AS `steps.duration`,
				`steps`.`image` AS `steps.image`,
				`steps`.`timeable` AS `steps.timeable`,
				`steps`.`timer_name` AS `steps.timer_name`,
				`step_todos`.`id` AS `todos.id`,
				`step_todos`.`description` AS `todos.description`,
				`ingredients`.`id` AS `ingredients.id`,
				`ingredients`.`name` AS `ingredients.name`,
				`step_ingredients`.`amount` AS `ingredients.amount`,
				`step_ingredients`.`unit` AS `ingredients.unit`
			FROM `steps`
			LEFT JOIN `step_todos` ON `step_todos`.`step_id` = `steps`.`id`
			LEFT JOIN `step_ingredients` ON `step_ingredients`.`step_id` = `steps`.`id`
			LEFT JOIN `ingredients` ON `ingredients`.`id` = `step_ingredients`.`ingredient_id`
			WHERE `steps`.`recipe_id` = :recipe_id
			ORDER BY `steps`.`id` ASC
		';
		$stmt = $this->_db->prepare($sql);
		$stmt->execute(array(':recipe_id' => $recipe->getId()));
		
		// Loop through all ingredients containing corresponding step information
		$steps = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			// Create the step object, if not already
			if(! isset($steps[$row['steps.id']])) {
				$steps[$row['steps.id']] = $this->create(array(
					'id' => $row['steps.id'],
					'title' => $row['steps.title'],
					'description' => $row['steps.description'],
					'duration' => $row['steps.duration'],
					'image' => $row['steps.image'],
					'timeable' => $row['steps.timeable'],
					'timer_name' => $row['steps.timer_name'],
					'recipe' => $recipe
				));
			}
			
			if(isset($row['todos.id'])) {
				$steps[$row['steps.id']]->addTodo(new Todo(array(
					'id' => $row['todos.id'],
					'description' => $row['todos.description']
				)));
			}
			
			if(isset($row['ingredients.id'])) {
				$steps[$row['steps.id']]->addIngredient(new Ingredient(array(
					'id' => $row['ingredients.id'],
					'name' => $row['ingredients.name'],
					'amount' => $row['ingredients.amount'],
					'unit' => $row['ingredients.unit']
				)));
			}
		}
		
		ksort($steps);
		
		return $steps;
	}
	
	/**
	 * Create a new Step entity
	 * 
	 * @param array $seed
	 */
	public function create($seed = array()) {
		return new Step($seed);
	}
}