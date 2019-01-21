<?php


namespace BaleBot;


use BaleBot\Model\GetFileUploadUrl;
use BaleBot\Model\Helper\PhotoHelper;
use BaleBot\Model\Helper\VideoHelper;
use BaleBot\Model\Message\Text;
use BaleBot\Model\SendPhotoMessage;
use BaleBot\Model\SendTextMessage;
use BaleBot\Model\SendVideoMessage;
use BaleBot\Model\Thumb;
use BaleBot\Response\FileUrlResponse;
use BaleBot\Response\SendMessageResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
	
	/**
	 * @param $text
	 * @param $nickName
	 * @return SendMessageResponse
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function sendTextMessage($text, $nickName)
	{
		$message = new SendTextMessage();
		$message->message->text = $text;
		$message->nickName = $nickName;
		
		return Request::make('messaging', $message)->response($this, SendMessageResponse::class)->body;
	}
	
	/**
	 * @param $filename
	 * @param $nickName
	 * @param $caption
	 * @return SendMessageResponse
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function sendPhotoMessage($filename, $nickName, $caption = null)
	{
		$helper = new PhotoHelper($filename);
		
		$message = new SendPhotoMessage();
		$message->nickName = $nickName;
		$file = $this->uploadFile($filename);
		$message->message->fileId = $file->fileId;
		$message->message->accessHash = $file->userId;
		$message->message->fileSize = filesize($filename);
		$message->message->name = basename($filename);
		$message->message->thumb = $helper->getThumb();
		$message->message->ext->height = $helper->height;
		$message->message->ext->width = $helper->width;
		
		if ($caption)
		{
			$message->message->caption->text = $caption;
		}
		echo Request::make('messaging', $message)->asJson();
		return Request::make('messaging', $message)->response($this, SendMessageResponse::class)->body;
	}
	
	/**
	 * @param $filename
	 * @param $nickName
	 * @param $caption
	 * @return SendMessageResponse
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function sendVideoMessage($filename, $nickName, $caption = null)
	{
		$helper = new VideoHelper($filename);
		
		$message = new SendVideoMessage();
		$message->nickName = $nickName;
		$file = $this->uploadFile($filename);
		$message->message->fileId = $file->fileId;
		$message->message->accessHash = $file->userId;
		$message->message->fileSize = filesize($filename);
		$message->message->name = basename($filename);
		$message->message->thumb = $helper->getThumb();
		$message->message->ext->height = $helper->height;
		$message->message->ext->width = $helper->width;
		$message->message->ext->duration = ceil($helper->duration);
		
		if ($caption)
		{
			$message->message->caption->text = $caption;
		}
		echo Request::make('messaging', $message)->asJson();
		return Request::make('messaging', $message)->response($this, SendMessageResponse::class)->body;
	}
	
	/**
	 * @param $filename
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @return FileUrlResponse
	 */
	public function uploadFile($filename)
	{
		$upload = new GetFileUploadUrl();
		$upload->crc = (string)hexdec(hash_file('crc32', $filename));
		$upload->size = filesize($filename);
		
		$uploadUrl = Request::make('files', $upload)->response($this, FileUrlResponse::class)->body;
		var_dump($uploadUrl);
		$r = $this->putFile($uploadUrl, $filename);
		
		return $uploadUrl;
	}
	
	/**
	 * @param FileUrlResponse $url
	 * @param string $filename
	 * @return boolean
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	private function putFile($url, $filename)
	{
		$request = new \GuzzleHttp\Psr7\Request("PUT", $url->url, ['filesize' => filesize($filename)],
			fopen($filename, 'r'));
		
		try
		{
			$response = $this->_client->send($request, ['timeout' => 25]);
			
			return $response->getStatusCode() == 200;
		}
		catch (GuzzleException $e)
		{
			throw $e;
		}
	}
}