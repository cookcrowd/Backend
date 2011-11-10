<?php
namespace Cookielicious\Model;

use Zurv\Model\Entity\Base as BaseEntity;

class Step extends BaseEntity {
	protected $_attributes = array(
		'id' => -1,
		'title' => '',
		'description' => '',
		'duration' => 0,
		'recipie' => null,
		'ingredients' => array()
	);
	
	public function addIngredient(Ingredient $i) {
		// Prevent double ingredients
		if(! array_search($i, $this->_attributes['ingredients'])) {
			array_push($this->_attributes['ingredients'], $i);
		}
	}
	
	public function removeIngredient(Ingredient $i) {
		if($key = array_search($i, $this->_attributes['ingredients'])) {
			unset($this->_attributes['ingredients'][$key]);
			return true;
		}
		
		return false;
	}
} 