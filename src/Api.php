<?php


namespace BaleBot;


use BaleBot\Model\SendMessage;
use BaleBot\Model\Text;
use GuzzleHttp\Client;

class Api
{
	const URL = "https://apitest.bale.ai/v1/bots/http/";
	
	private $_token;
	
	/**
	 * @var Client
	 */
	private $_client;
	
	public function __construct($api_token)
	{
		$this->_token = $api_token;
		
		$this->_client = new Client([
			'http_errors' => false,
			'verify' => false,
			'headers' => [
				'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0'
			]
		]);
	}
	
	public function getToken()
	{
		return $this->_token;
	}
	
	/**
	 * @return Client
	 */
	public function getClient()
	{
		return $this->_client;
	}
	
	public function sendTextMessage($text, $nickName)
	{
		$message = new SendMessage();
		$message->message = new Text();
		$message->message->text = $text;
		$message->nickName = $nickName;
		
		
		return Request::make($this, 'messaging', $message)->response();
	}
}