<?php


namespace BaleBot\Model\Message;

use BaleBot\Model\Thumb;

/**
 * Class Photo
 * @package BaleBot\Model\Message
 *
 * @property \BaleBot\Model\Ext\Photo $ext
 */
class Photo extends Document
{
	protected $relations = [
		'thumb' => Thumb::class,
		'caption' => Text::class,
		'ext' => \BaleBot\Model\Ext\Photo::class,
	];
	
	public function __construct(array $_attributes = [])
	{
		parent::__construct($_attributes);
		$this->mimeType = 'image/jpeg';
	}
}