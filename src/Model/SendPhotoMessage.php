<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class SendMessage
 * @package BaleBot\Model
 *
 * @property string $nickName
 * @property string $randomId
 * @property Model\Message\Photo $message
 */
class SendPhotoMessage extends SendMessage
{
	protected $relations = [
		'message' => Model\Message\Photo::class,
	];
}