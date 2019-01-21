<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class SendMessage
 * @package BaleBot\Model
 *
 * @property string $nickName
 * @property string $randomId
 * @property Model $message
 */
abstract class SendMessage extends Model
{
	protected $_type = 'SendMessage';
	
	public function __construct($_attributes = [])
	{
		$this->randomId = mt_rand(1, 99999);
		parent::__construct($_attributes);
	}
	
	/**
	 * @param array $data
	 * @return Model|SendDocumentMessage|SendTextMessage
	 * @throws \Exception
	 */
	public static function create($data = [])
	{
		if (static::class != self::class)
			return parent::create($data);
		
		switch ($data['message']->type)
		{
			case 'Text':
				return SendTextMessage::create($data);
			case 'Document':
				if (!$data['ext'])
					return SendDocumentMessage::create($data);
				
				switch ($data['ext']->type)
				{
					case 'Photo':
						return SendPhotoMessage::create($data);
					case 'Video':
						return SendVideoMessage::create($data);
					case 'Voice':
						return SendVoiceMessage::create($data);
					default:
						throw new \Exception("Unsupported type for message");
				}
			default:
				throw new \Exception("Unsupported type for message");
		}
	}
}