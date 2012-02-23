<?php
use Cookielicious\Model\RecipeMapper;

class RecipesHandler extends BaseHandler {
	public function get_xhr() {
		$ingredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : array();
		
		if(! is_array($ingredients) || empty($ingredients)) {
			return $this->_view->display(array('error' => 'No ingredients passed to search for'));
		}
		
		require_once 'models/mappers/RecipeMapper.php';

		$recipeMapper = new RecipeMapper();
		if(! ($recipes = $recipeMapper->findByIngredients($ingredients))) {
			return $this->_view->display(array('error' => 'No recipes found for specified ingredients'));
		}
		
		// Convert each recipe to its array representation
		foreach($recipes as &$recipe) {
			$recipe = $recipe->toArray();
		}
		
		return $this->_view->display($recipes);
	}
}