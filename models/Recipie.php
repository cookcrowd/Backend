<?php
namespace Cookielicious\Model;

use Zurv\Model\Entity\Base as BaseEntity;

class Recipie extends BaseEntity {
	protected $_attributes = array(
		'id' => -1,
		'title' => '',
		'preparation_time' => 0,
		'thumbnail' => '',
		'steps' => null
	);
} 