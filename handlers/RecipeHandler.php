<?php
use Cookielicious\Model\RecipeMapper;

class RecipeHandler extends BaseHandler {
	/**
	 * Returns a recipe by its id. If no recipe found, sends an error
	 * @param int $id
	 */
	public function get($id) {
		require_once 'models/mappers/RecipeMapper.php';

		$recipeMapper = new RecipeMapper();
		// Check for a valid recipe
		if(! ($recipe = $recipeMapper->findById($id))) {
			return $this->_view->display(array('error' => "No recipe found for id {$id}"));	
		}
		
		return $this->_view->display($recipe->toArray());
	}
}