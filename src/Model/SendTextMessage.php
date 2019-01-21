<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class SendMessage
 * @package BaleBot\Model
 *
 * @property string $nickName
 * @property string $randomId
 * @property Model\Message\Text $message
 */
class SendTextMessage extends SendMessage
{
	protected $relations = [
		'message' => Model\Message\Text::class,
	];
}