<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageIngredientsHandler extends AuthBaseHandler {
  
  protected $_template = 'index.php';

  public function get() {
    $this->isLoggedIn();

    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/ingredients.php');
    $ingredientsView = new View($viewAdapter);

    require_once 'models/mappers/IngredientMapper.php';
    $ingredientMapper = new IngredientMapper();

    $ingredients = $ingredientMapper->fetchAll();
    $ingredientsView->ingredients = $ingredients;

    $this->_view->content = $ingredientsView;
    $this->_view->display();
  }

  public function post_xhr() {
    $this->isLoggedIn();

    if(isset($_POST['name'])) {
      require_once "models/mappers/IngredientMapper.php";
      
      $ingredientMapper = new IngredientMapper();
      $ingredient = $ingredientMapper->create(array('name' => $_POST['name']));
      
      $this->_view->id = $ingredientMapper->save($ingredient);
    }
    else {
      $this->_view->error = 'No ingredient name given';
    }
    
    $this->_view->display();
  }
}