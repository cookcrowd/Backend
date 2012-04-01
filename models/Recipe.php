<?php
namespace Cookielicious\Model;

use Zurv\Model\Entity\Base as BaseEntity;

class Recipe extends BaseEntity {
  protected $_attributes = array(
    'id' => -1,
    'title' => '',
    'preparation_time' => 0,
    'image' => '',
    'ingredient_match' => -1,
    'steps' => array()
  );
  
  /**
   * Append a step to the recipes step list
   * 
   * @param Step $s
   * @return void
   */
  public function addStep(Step $s) {
    if(! array_search($s, $this->_attributes['steps'])) {
      array_push($this->_attributes['steps'], $s);
    }
  }
  
  /**
   * Remove a step from the recipes step list
   * 
   * @param Step $s
   * @return bool
   */
  public function removeStep(Step $s) {
    if($key = array_search($s, $this->_attributes['steps'])) {
      unset($this->_attributes['steps'][$key]);
      return true;
    }
    
    return false;
  }

  /**
   * Returns the preparation time formatted as a human readable string
   *
   * @return string
   */
  public function formatPreparationTime() {
    $total = $this->getPreparationTime();

    $hours = (int)floor($total/60);
    $minutes = (int)floor($total - ($hours * 60));

    $return = '';
    if($hours === 1) {
      $return = "eine Stunde";
    }
    else if($hours > 1) {
      $return = "{$hours} Stunden";
    }

    if($minutes === 1) {
      $return .= strlen($return) > 0 ? "und eine Minute" : "eine Minute";
    }
    else if($minutes > 1) {
      $return .= strlen($return) > 0 ? "und {$minutes} Minuten" : "{$minutes} Minuten";
    }

    return $return;
  }
  
  /**
   * Returns all used ingredients
   *
   * @return array|string
   */
  public function getIngredients($separator = '') {
    $ingredients = array();

    foreach($this->getSteps() as $step) {
      if(empty($separator)) {
        $ingredients = array_merge($ingredients, $step->getIngredients());
      }
      else {
        foreach($step->getIngredients() as $ingredient) {
          array_push($ingredients, $ingredient->getName());
        }
      }
    }

    return empty($separator) ? $ingredients : join($separator, $ingredients);
  }

  /**
   * @see Zurv\Model\Entity.Base::toArray()
   */
  public function toArray() {
    $array = $this->_attributes;
    
    if(is_array($array['steps'])) {
      foreach($array['steps'] as &$step) {
        $step = $step->toArray(true);
      }
    }
    
    return $array;
  }
} 