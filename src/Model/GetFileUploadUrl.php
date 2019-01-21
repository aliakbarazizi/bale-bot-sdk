<?php


namespace BaleBot\Model;


use BaleBot\Model;

/**
 * Class GetFileUploadUrl
 * @package BaleBot\Model
 *
 * @property string $crc
 * @property int $size
 * @property boolean $isServer
 * @property string $fileType
 */
class GetFileUploadUrl extends Model
{
	protected $_attributes = [
		'isServer' => false,
		'fileType' => 'file',
	];
}