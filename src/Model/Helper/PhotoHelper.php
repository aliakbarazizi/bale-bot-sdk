<?php


namespace BaleBot\Model\Helper;

use BaleBot\Model;

class PhotoHelper
{
	public $duration;
	
	public $width;
	
	public $height;
	
	/**
	 * @var resource
	 */
	private $_image;
	
	public function __construct($filename)
	{
		/* read the source image */
		$this->_image = imagecreatefromjpeg($filename);
		$this->width = imagesx($this->_image);
		$this->height = imagesy($this->_image);
	}
	
	public function getThumb($width = null, $height = null)
	{
		/* read the source image */
		if ($width === null)
		{
			if ($this->width > 700)
			{
				$width = 700;
			}
			else
			{
				$width = $this->width;
			}
		}
		
		if ($height === null)
		{
			$height = floor($this->height * ($width / $this->width));
		}
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($width, $height);
		
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $this->_image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
		
		/* create the physical thumbnail image to its destination */
		ob_start();
		imagejpeg($virtual_image);
		$image = ob_get_clean();
		
		$image = base64_encode($image);
		
		$thumb = new Model\Thumb();
		$thumb->width = $width;
		$thumb->height = $height;
		$thumb->thumb = $image;
		
		return $thumb;
	}
}