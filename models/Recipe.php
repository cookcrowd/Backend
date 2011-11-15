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
		'steps' => null
	);
	
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