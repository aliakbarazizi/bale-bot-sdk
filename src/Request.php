<?php


namespace BaleBot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Runner\Exception;

/**
 * Class Request
 * @package Social\Bale\Api
 *
 * @property string $id
 * @property string $service
 */
class Request extends Model
{
	protected $_type = 'Request';
	
	protected $_id;
	
	protected $_service;
	
	/**
	 * @var Api
	 */
	protected $_api;
	
	/**
	 * Request constructor.
	 * @param Api $api
	 * @param null $_attributes
	 */
	public function __construct($api, $_attributes = null)
	{
		if (isset($_attributes['id']))
		{
			$this->_id = $_attributes['id'];
			unset($_attributes['id']);
		}
		
		if (isset($_attributes['service']))
		{
			$this->_service = $_attributes['service'];
			unset($_attributes['service']);
		}
		
		$this->_api = $api;
		
		parent::__construct($_attributes);
	}
	
	public function getService()
	{
		return $this->_service;
	}
	
	public function setService($service)
	{
		$this->_service = $service;
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
		
		$json['service'] = $this->service;
		$json['id'] = $this->id;
		
		return $json;
	}
	
	/**
	 * @return Response
	 * @throws GuzzleException
	 */
	public function response()
	{
		return $this->sendRequest();
	}
	
	/**
	 * @param $api
	 * @param $service
	 * @param Api $model
	 * @return Request
	 */
	public static function make($api, $service, $model)
	{
		return new self($api, ['body' => $model,'service' => $service]);
	}
	
	
	protected function sendRequest()
	{
		$url = Api::URL . $this->_api->getToken();
		
		$request = new \GuzzleHttp\Psr7\Request("POST", $url, ['Content-Type' => 'application/json'], $this->asJson());
		
		try
		{
			echo $this->asJson();
			
			$response = $this->_api->getClient()->send($request, ['timeout' => 25]);
			
			$json = json_decode($response->getBody()->getContents(), true);
			
			if (json_last_error() == JSON_ERROR_NONE)
			{
				return Response::fromArray($json);
			}
			
			echo $response->getBody();
			
			throw new Exception($response->getBody()->getContents());
		}
		catch (GuzzleException $e)
		{
			throw $e;
		}
	}
}