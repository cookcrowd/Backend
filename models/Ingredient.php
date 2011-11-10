<?php
namespace Cookielicious\Model;

use Zurv\Model\Entity\Base as BaseEntity;

class Ingredient extends BaseEntity {
	protected $_attributes = array(
		'id' => -1,
		'name' => ''
	);
}