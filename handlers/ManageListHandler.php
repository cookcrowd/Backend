<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageListHandler extends AuthBaseHandler {
  protected $_template = 'index.php';

  /**
   * Permitted backend users
   * @var array
   */
  public static $users = array(
    'admin' => 'admin'
  );

  public function get() {
    $this->isLoggedIn();

    require_once 'models/mappers/RecipeMapper.php';
    $recipeMapper = new RecipeMapper();

    $latestRecipes = $recipeMapper->getLatest();

    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/list.php');
    $listView = new View($viewAdapter);

    $listView->latestRecipes = $latestRecipes;
    
    $this->_view->content = $listView;
    $this->_view->display();
  }

  public function get_xhr() {

  }
}