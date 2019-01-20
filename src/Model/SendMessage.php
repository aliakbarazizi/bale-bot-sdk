<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class SendMessage
 * @package BaleBot\Model
 *
 * @property string $nickName
 * @property string $randomId
 * @property Text $message
 */
class SendMessage extends Model
{
	public function __construct($_attributes = [])
	{
		$this->randomId = mt_rand(1, 99999);
		parent::__construct($_attributes);
	}
}