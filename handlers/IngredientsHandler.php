<?php
use Cookielicious\Model\IngredientMapper;

class IngredientsHandler extends BaseHandler {
	/**
	 * Returns a list of all existing ingredients
	 */
	public function get_xhr() {
		require_once "models/mappers/IngredientMapper.php";
		
		$ingredientMapper = new IngredientMapper();
		
		if(! isset($_GET['s'])) {
			if(! ($ingredients = $ingredientMapper->fetchAll())) {
				return $this->_view->display(array('error' => 'No ingredients could be found'));
			}
		}
		else {
			if(! ($ingredients = $ingredientMapper->search($_GET['s']))) {
				return $this->_view->display(array('error' => 'No ingredients could be found'));
			}
		}
		
		// Convert each ingredient to its array representation
		foreach($ingredients as &$ingredient) {
			$ingredient = $ingredient->toArray();
			
			// Remove unneccesary data, keep responses small
			unset($ingredient['amount']);
			unset($ingredient['unit']);
		}
		
		return $this->_view->display($ingredients);
	}
}