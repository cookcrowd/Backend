<?php
class RecipieHandler extends BaseHandler {
	public function get() {
		require_once 'models/mappers/RecipieMapper.php';

		$recipieMapper = new Cookielicious\Model\RecipieMapper();
		$recipie = $recipieMapper->findById(1);
		
		echo "<ul>";
		foreach($recipie->getSteps() as $step) {
			echo "<li>{$step->getTitle()}<ul>";
			foreach($step->getIngredients() as $ingredient) {
				echo "<li>{$ingredient->getName()}</li>";
			}
			echo "</ul></li>";		
		}
		echo "</ul>";
	}
}