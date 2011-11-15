<?php
use Cookielicious\Model\IngredientMapper;

class IngredientsHandler extends BaseHandler {
	/**
	 * Returns a list of all existing ingredients
	 */
	public function get() {
		require_once "models/mappers/IngredientMapper.php";
		
		$ingredientMapper = new IngredientMapper();
		if(! ($ingredients = $ingredientMapper->fetchAll())) {
			return $this->_view->display(array('error' => 'No ingredients could be found'));
		}
		
		// Convert each ingredient to its array representation
		foreach($ingredients as &$ingredient) {
			$ingredient = $ingredient->toArray();
		}
		
		return $this->_view->display($ingredients);
	}
}