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