<?php
namespace Cookielicious\Model;

use Zurv\Model\Mapper\Base as BaseMapper;
use Zurv\Registry;
use PDO;

require_once 'models/Recipie.php';

class RecipieMapper extends BaseMapper {
	protected $_db = null;
	
	public function __construct() {
		$this->_db = Registry::getInstance()->db;
	}
	
	/**
	 * Find a recipie by its id
	 * 
	 * @param int $id
	 * @return Recipie|false
	 */
	public function findById($id) {
		$sql = '
			SELECT `id`, `title`, `preparation_time`, `thumbnail`
			FROM `recipies`
			WHERE `id` = :id
		';
		$stmt = $this->_db->prepare($sql);
		
		$stmt->execute(array(':id' => $id));
		$recipie = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(! empty($recipie)) {
			$recipie = $this->create($recipie);
			
			// Fetch ingredients
			require_once 'models/mappers/StepMapper.php';
			
		}
		
		// No strip found
		return false;
	}
	
	/**
	 * Fetch all recipies
	 * 
	 * @return array
	 */
	public function fetchAll() {
		$stmt = $this->_db->query('SELECT * FROM `images` ORDER BY `date` DESC');
		
		$strips = array();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			array_push($strips, $this->create($row));
		}
		
		return $strips;
	}

	/**
	 * Saves a recipie to the database
	 * 
	 * @param Recipie $recipie
	 */
	public function save(Recipie $recipie) {
		if($recipie->getId() < 0) {
			$this->insert($recipie);
		}
		else {
			$this->update($recipie);
		}
	}
	
	/**
	 * Insert a new recipie to the database
	 * 
	 * @param Recipie $recipie
	 */
	public function insert($recipie) {
		$sql = '
			INSERT INTO `recipies`
			()
			VALUES ()
		';
		$stmt = $this->_db->prepare($sql);
		return $stmt->execute(
			array(
				// TODO: Set statement parameters
			)
		);
	}
	
	/**
	 * Update a recipie in the database
	 * 
	 * @param Recipie $recipie
	 */
	public function update($recipie) {
		$sql = '
			UPDATE `recipies`
			SET
				
		';
		$stmt = $this->_db->prepare($sql);
		return $stmt->execute(
			array(
				// TODO: Set statement parameters
			)
		);
	}
	
	/**
	 * Delete a recipie from the database
	 * 
	 * @param int $id
	 */
	public function delete($id) {
		$stmt = $this->_db->prepare('DELETE FROM `recipies` WHERE `id` = :id');
		return $stmt->execute(array(':id' => $id));
	}
	
	/**
	 * Create an new Recipie object
	 * 
	 * @param array $seed
	 */
	public function create($seed = array()) {
		return new Recipie($seed);
	}
}