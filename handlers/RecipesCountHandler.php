<?php
use Cookielicious\Model\RecipeMapper;

class RecipesCountHandler extends BaseHandler {
	public function get_xhr() {
		$ingredients = isset($_GET['ingredients']) ? $_GET['ingredients'] : array();
		
		if(! is_array($ingredients) || empty($ingredients)) {
			return $this->_view->display(array('count' => 0));
		}
		
		require_once 'models/mappers/RecipeMapper.php';

		$recipeMapper = new RecipeMapper();
		return $this->_view->display(array('count' => intval($recipeMapper->countByIngredients($ingredients))));
	}
}