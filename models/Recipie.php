<?php
namespace Cookielicious\Model;

class Recipie extends \Zurv\Model\Entity\Base {
	protected $_attributes = array(
		'id' => -1,
		'title' => '',
		'preparation_time' => 0,
		'thumbnail' => '',
		'steps' => null
	);
} 