<?php


namespace BaleBot\Model\Message;


use BaleBot\Model;

/**
 * Class Document
 * @package BaleBot\Model\Message
 *
 * @property int $fileId
 * @property string $accessHash
 * @property int $fileStorageVersion
 * @property int $fileSize
 * @property string $name
 * @property string $mimeType
 * @property string $checkSum
 * @property string $algorithm
 * @property Model\Thumb $thumb
 * @property Model\Extra $ext
 * @property Text $caption
 */
class Document extends Model
{
	protected $_type = 'Document';
	
	protected $_attributes = [
		'algorithm' => 'algorithm',
		'checkSum' => 'checkSum',
		'fileStorageVersion' => 1,
	];
	
	protected $relations = [
		'thumb' => Model\Thumb::class,
		'ext' => Model\Extra::class,
		'caption' => Text::class,
	];
}