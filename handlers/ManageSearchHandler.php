<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use Cookielicious\Model\Recipe;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

require_once 'models/mappers/RecipeMapper.php';

class ManageSearchHandler extends AuthBaseHandler {

  protected $_template= 'index.php';

  public function get($id) {
    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/search.php');
    $searchView = new View($viewAdapter);

    $this->_view->content = $searchView;
    $this->_view->display();
  }
}