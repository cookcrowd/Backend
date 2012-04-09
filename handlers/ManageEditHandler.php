<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageEditHandler extends AuthBaseHandler {

  protected $_template= 'index.php';

  public function get($id) {
    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/form.php');
    $editView = new View($viewAdapter);

    require_once 'models/mappers/RecipeMapper.php';
    $recipeMapper = new RecipeMapper();
    $recipe = $recipeMapper->findById($id);

    $editView->recipe = $recipe;

    $this->_view->content = $editView;
    $this->_view->display();
  }

  public function post($id) {
    echo '<pre>';
    var_dump($_POST);
    echo $id;
    echo '</pre>';
    exit;
  }
}