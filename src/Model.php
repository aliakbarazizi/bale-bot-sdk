<?php


namespace BaleBot;

/**
 * Class Model
 * @package Social\Bale\Api
 *
 * @property string $type
 * @property array $attributes
 */
abstract class Model implements \JsonSerializable
{
	protected $_type;
	
	protected $_attributes = [];
	
	protected $relations;
	
	public function __construct($_attributes = [])
	{
		if ($_attributes)
		{
			if (isset($_attributes['$type']))
			{
				$this->_type = $_attributes['$type'];
				unset($_attributes['$type']);
			}
		}
		$this->_attributes = array_merge($this->_attributes, $_attributes);
		
		if ($this->_type == null)
		{
			$this->_type = substr(static::class, strrpos(static::class, '\\') + 1);
		}
	}
	
	public function __get($name)
	{
		$method = 'get' . ucfirst($name);
		
		if (method_exists($this, $method))
		{
			return call_user_func([$this, $method]);
		}
		
		if (isset($this->_attributes[$name]))
		{
			return $this->_attributes[$name];
		}
		
		if (isset($this->_relations[$name]))
		{
			return $this->_attributes[$name] = new $this->relations[$name];
		}
		
		return null;
	}
	
	public function __set($name, $value)
	{
		$method = 'set' . ucfirst($name);
		
		if (method_exists($this, $method))
		{
			return call_user_func([$this, $method], $value);
		}
		
		return $this->_attributes[$name] = $value;
	}
	
	
	public function getType()
	{
		return $this->_type;
	}
	
	public function setType($type)
	{
		$this->_type = $type;
	}
	
	public function getAttributes()
	{
		return $this->_attributes;
	}
	
	public function asArray()
	{
		return array_merge(['$type' => $this->_type], $this->_attributes);
	}
	
	/**
	 * @return string
	 */
	public function asJson()
	{
		return json_encode($this->asArray());
	}
	
	/**
	 * @param $data
	 * @return static
	 */
	public static function fromArray($data)
	{
		foreach ($data as $key => $value)
		{
			if (isset($value['$type']))
			{
				$modelClass = '\\BaleBot\\Model\\' . $value['$type'];
				/* @var $modelClass Model */
				$data[$key] = $modelClass::fromArray($value);
			}
		}
		
		$model = new static($data);
		
		return $model;
	}
	
	/**
	 * @param $json
	 * @return static
	 */
	public static function fromJsom($json)
	{
		return static::fromArray(json_decode($json, true));
	}
	
	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize()
	{
		return $this->asArray();
	}
}