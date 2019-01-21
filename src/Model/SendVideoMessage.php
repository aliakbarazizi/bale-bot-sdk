<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class SendMessage
 * @package BaleBot\Model
 *
 * @property string $nickName
 * @property string $randomId
 * @property Model\Message\Video $message
 */
class SendVideoMessage extends SendMessage
{
	protected $relations = [
		'message' => Model\Message\Video::class,
	];
}