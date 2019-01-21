<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class SendMessage
 * @package BaleBot\Model
 *
 * @property string $nickName
 * @property string $randomId
 * @property Model\Message\Document $message
 */
class SendDocumentMessage extends SendMessage
{
	protected $relations = [
		'message' => Model\Message\Document::class,
	];
}