<?php


namespace BaleBot;

use GuzzleHttp\Exception\GuzzleException;

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
	 * Request constructor.
	 * @param null $_attributes
	 */
	public function __construct($_attributes = null)
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
	 * @param Api $api
	 * @param $response
	 * @return Response
	 * @throws GuzzleException
	 */
	public function response($api, $response)
	{
		return $this->sendRequest($api, $response);
	}
	
	/**
	 * @param $service
	 * @param Model $model
	 * @return Request
	 */
	public static function make($service, $model)
	{
		return new self(['body' => $model,'service' => $service]);
	}
	
	/**
	 * @param Api $api
	 * @param $responseClass
	 * @return Response
	 * @throws \Exception
	 * @throws GuzzleException
	 */
	protected function sendRequest($api, $responseClass)
	{
		$url = Api::URL . $api->getToken();
		
		$request = new \GuzzleHttp\Psr7\Request("POST", $url, ['Content-Type' => 'application/json'], $this->asJson());
		
		try
		{
			$response = $api->getClient()->send($request, ['timeout' => 25]);
			
			$json = json_decode($response->getBody()->getContents(), true);
			
			if (json_last_error() == JSON_ERROR_NONE)
			{
				return Response::fromArray($json, $responseClass);
			}
			
			throw new \Exception($response->getBody()->getContents());
		}
		catch (\Exception $e)
		{
			throw $e;
		}
	}
}