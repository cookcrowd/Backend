<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use Cookielicious\Model\Recipe;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

require_once 'models/mappers/RecipeMapper.php';

class ManageAddHandler extends AuthBaseHandler {

  protected $_template= 'index.php';

  public function get($id) {
    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/form.php');
    $addView = new View($viewAdapter);

    $recipe = new Recipe();
    $addView->recipe = $recipe;

    $this->_view->content = $addView;
    $this->_view->display();
  }
}