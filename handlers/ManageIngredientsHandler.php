<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageIngredientsHandler extends AuthBaseHandler {
  
  protected $_template = 'index.php';

  public function get() {
    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/ingredients.php');
    $ingredientsView = new View($viewAdapter);

    require_once 'models/mappers/IngredientMapper.php';
    $ingredientMapper = new IngredientMapper();

    $ingredients = $ingredientMapper->fetchAll();
    $ingredientsView->ingredients = $ingredients;

    $this->_view->content = $ingredientsView;
    $this->_view->display();
  }
}