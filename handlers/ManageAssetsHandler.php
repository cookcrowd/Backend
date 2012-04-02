<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageAssetsHandler extends AuthBaseHandler {
  
  protected $_template = 'index.php';

  public function get() {
    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/assets.php');
    $ingredientsView = new View($viewAdapter);

    $this->_view->content = $ingredientsView;
    $this->_view->display();
  }
}