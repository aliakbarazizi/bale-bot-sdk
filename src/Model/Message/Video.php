<?php


namespace BaleBot\Model\Message;

use BaleBot\Model\Thumb;

/**
 * Class Video
 * @package BaleBot\Model\Message
 *
 * @property \BaleBot\Model\Ext\Video $ext
 */
class Video extends Document
{
	protected $relations = [
		'thumb' => Thumb::class,
		'caption' => Text::class,
		'ext' => \BaleBot\Model\Ext\Video::class,
	];
	
	public function __construct(array $_attributes = [])
	{
		parent::__construct($_attributes);
		$this->mimeType = 'video/mp4';
	}
}