<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageDeleteHandler extends AuthBaseHandler {
  public function get_xhr() {
    echo 'No access';
  }
}