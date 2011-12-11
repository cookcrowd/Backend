<?php
namespace Cookielicious\Model;

use Zurv\Model\Entity\Base as BaseEntity;

class Step extends BaseEntity {
	protected $_attributes = array(
		'id' => -1,
		'title' => '',
		'description' => '',
		'duration' => 0,
		'recipe' => null,
		'ingredients' => array(),
		'todos' => array(),
		'image' => ''
	);
	
	/**
	 * Add ingredient to recipe step
	 * 
	 * @param Ingredient $i
	 * @return void
	 */
	public function addIngredient(Ingredient $i) {
		// Prevent double ingredients
		foreach($this->_attributes['ingredients'] as $ingredient) {
			if($ingredient->equals($i)) {
				return;
			}
		}
		
		array_push($this->_attributes['ingredients'], $i);
	}
	
	/**
	 * Remove ingredient from recipe step
	 * 
	 * @param Ingredient $i
	 * @return bool
	 */
	public function removeIngredient(Ingredient $i) {
		if($key = array_search($i, $this->_attributes['ingredients'])) {
			unset($this->_attributes['ingredients'][$key]);
			return true;
		}
		
		return false;
	}
	
	/**
	 * Add step todo
	 * 
	 * @param Todo $t
	 */
	public function addTodo(Todo $t) {
		// Prevent double todos
		foreach($this->_attributes['todos'] as $todo) {
			if($todo->equals($t)) {
				return;
			}
		}
		
		array_push($this->_attributes['todos'], $t);
	}
	
	/**
	 * Remove todo from step
	 * 
	 * @param Todo $t
	 * @return bool
	 */
	public function removeTodo(Todo $t) {
		if($key = array_search($t, $this->_attributes['todos'])) {
			unset($this->_attributes['todos'][$key]);
			return true;
		}
		
		return false;
	}
	
	/**
	 * @see Zurv\Model\Entity.Base::toArray()
	 */
	public function toArray($nonRecursive = false) {
		$array = $this->_attributes;
		
		foreach($array['ingredients'] as &$ingredient) {
			$ingredient = $ingredient->toArray();
		}
		
		foreach($array['todos'] as &$todo) {
			$todo = $todo->toArray();
		}
		
		// Non recursive
		if($nonRecursive) {
			unset($array['recipe']);
		}
		
		return $array;
	}
} 