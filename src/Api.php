<?php


namespace Social;


use GuzzleHttp\Client;

class Api
{
	private $_api = "https://apitest.bale.ai/v1/bots/http/";
	
	private $_token;
	
	/**
	 * @var Client
	 */
	private $_client;
	
	public function __construct($api_token)
	{
		$this->_token = $api_token;
		
		$this->_client = new Client();
	}
	
	
	
	protected function sendRequest($model, $params = [])
	{
		/* @var $class Response\Base */
		$class = new $model();
		
		$data = '';
		
		if ($class->tokenRequired)
		{
			$data = "/luser/{$this->_username}/ltoken/{$this->_token}";
		}
		
		foreach ($params as $name => $value)
		{
			$data .= '/' . $name . "/" . urlencode($value);
		}
		
		$request = new Request("GET", $this->url . $class->method . $data);
		
		$response = $this->_client->send($request, ['timeout' => 25]);
		
		
		$r = json_decode($response->getBody(), true);
		
		if ($response->getStatusCode() == 200 && $r[$class->method]['type'] != 'error')
		{
			$class->setAttributes($r[$class->method]);
		}
		else
		{
			throw new InvalidParamException($r[$class->method]['value']);
		}
		
		return $class;
	}
}