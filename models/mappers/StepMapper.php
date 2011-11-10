<?php
namespace Cookielicious\Model;

use Zurv\Model\Mapper\Base as BaseMapper;
use Zurv\Registry;
use PDO;

require_once 'models/Step.php';
require_once 'models/Ingredient.php';

class StepMapper extends BaseMapper {
	/**
	 * @var PDO
	 */
	protected $_db = null;
	
	public function __construct() {
		$this->_db = Registry::getInstance()->db;
	}
	
	/**
	 * Find all steps for a recipie
	 * 
	 * @param Recipie|id $recipie
	 */
	public function findByRecipie(Recipie $recipie) {
		$sql = '
			SELECT
				`steps`.`id` AS `steps.id`,
				`steps`.`title` AS `steps.title`,
				`steps`.`description` AS `steps.description`,
				`steps`.`duration` AS `steps.duration`,
				`ingredients`.`id` AS `ingredients.id`,
				`ingredients`.`name` AS `ingredients.name`
			FROM `steps`
			LEFT JOIN `step_ingredients` ON `step_ingredients`.`step_id` = `steps`.`id`
			LEFT JOIN `ingredients` ON `ingredients`.`id` = `step_ingredients`.`ingredient_id`
			WHERE `steps`.`recipie_id` = :recipie_id
		';
		$stmt = $this->_db->prepare($sql);
		$stmt->execute(array(':recipie_id' => $recipie->getId()));
		
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
					'recipie' => $recipie
				));
			}
			
			$steps[$row['steps.id']]->addIngredient(new Ingredient(array(
				'id' => $row['ingredients.id'],
				'name' => $row['ingredients.name']
			)));
		}
		
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