<?php
use Cookielicious\Model\RecipeMapper;
use Cookielicious\Model\IngredientMapper;
use Cookielicious\Model\Step;

use \Zurv\View\View;
use \Zurv\View\Adapter\Factory as ViewFactory;

class ManageHandler extends AuthBaseHandler {
  const UPLOAD_PATH = 'assets/';
  const INGREDIENT_SEPARATOR = ':::';
  
  protected $_template = 'index.php';
  
  public function get() {
    $this->isLoggedIn();
    
    $viewAdapter = ViewFactory::create(ViewFactory::FILE, 'views/welcome.php');
    $welcomeView = new View($viewAdapter);

    $this->_view->content = $welcomeView;
    $this->_view->display();
  }
  
  public function post_xhr() {
    $this->isLoggedIn();
    
    if(isset($_POST['ingredient']) && $_POST['ingredient']) {
      return $this->addIngredient();
    }
  }
  
  public function post() {
    $this->isLoggedIn();
    
    if(! empty($_POST)) {
      require_once 'models/mappers/RecipeMapper.php';
      $recipeMapper = new RecipeMapper();
      
      /**
       * @var Recipe
       */
      $recipe = $recipeMapper->create(array(
        'title' => $_POST['title'],
        'preparation_time' => intval($_POST['preparation-time'])
      ));
      
      // Handle image
      if(is_uploaded_file($_FILES['image']['tmp_name'])) {
        $filename = uniqid('', true);
        $ext = substr($_FILES['image']['name'], strrpos($_FILES['image']['name'], '.'));
        
        if(! move_uploaded_file($_FILES['image']['tmp_name'], self::UPLOAD_PATH . $filename . $ext)) {
          throw new Exception('Cannot move uploaded file');
        }
        
        $recipe->setImage($filename . $ext);
      }
      
      // Add steps
      if(isset($_POST['step']) && is_array($_POST['step'])) {
        require_once 'models/Step.php';
        
        foreach($_POST['step'] as $index => $currStep) {
          $step = new Step(array(
            'title' => $currStep['title'],
            'description' => $currStep['description'],
            'duration' => intval($currStep['duration']),
            'recipe' => $recipe
          ));
          
          // Handle ingredients
          if(isset($_POST['ingredients']) && isset($_POST['ingredients'][$index])) {
            if(is_array($_POST['ingredients'][$index])) {
              require_once 'models/mappers/IngredientMapper.php';
              $ingredientMapper = new IngredientMapper();
              
              foreach($_POST['ingredients'][$index] as $ingredient) {
                list($id, $amount, $unit) = explode(self::INGREDIENT_SEPARATOR, $ingredient);
                
                $ingredient = $ingredientMapper->findById($id);
                $ingredient->setAmount($amount);
                $ingredient->setUnit($unit);
                
                $step->addIngredient($ingredient);
              }
            }
          }
          
          // Handle step image
          if(is_uploaded_file($_FILES['step']['tmp_name'][$index]['image'])) {
            $filename = uniqid('', true);
            $ext = substr($_FILES['step']['name'][$index]['image'], strrpos($_FILES['step']['name'][$index]['image'], '.'));
            
            if(! move_uploaded_file($_FILES['step']['tmp_name'][$index]['image'], self::UPLOAD_PATH . $filename . $ext)) {
              throw new Exception('Cannot move step uploaded file');
            }
            
            $step->setImage($filename . $ext);
          }
          
          $recipe->addStep($step);
        }
      }
      
      $recipeMapper->save($recipe);
    }
    
    $this->_view->display();
  }
  
  public function addIngredient() {
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