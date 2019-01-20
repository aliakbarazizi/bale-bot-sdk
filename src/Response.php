<?php


namespace BaleBot;

/**
 * Class Request
 * @package Social\Bale\Api
 *
 * @property string $id
 * @property string $service
 */
class Response extends Model
{
	protected $_type = 'Response';
	
	protected $_id;
	
	public function __construct($_attributes = null)
	{
		if (isset($_attributes['id']))
		{
			$this->_id = $_attributes['id'];
			unset($_attributes['id']);
		}
		
		parent::__construct($_attributes);
	}
	
	public function getId()
	{
		if ($this->_id == null)
		{
			$this->_id = mt_rand(1, 9999);
		}
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
	}
	
	public function asArray()
	{
		$json = parent::asArray();
		$json['id'] = $this->id;
		return $json;
	}
}