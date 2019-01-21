<?php


namespace BaleBot\Model\Helper;


use BaleBot\Model;

class VideoHelper
{
	public $duration;
	
	public $width;
	
	public $height;
	
	/**
	 * @var \FFMpeg\Media\Audio|\FFMpeg\Media\Video
	 */
	private $_video;
	
	public function __construct($filename)
	{
		$ffmpeg = \FFMpeg\FFMpeg::create([
			'ffmpeg.binaries'  => 'c:\ffmpeg\ffmpeg.exe',
			'ffprobe.binaries' => 'c:\ffmpeg\ffprobe.exe'
		]);
		$this->_video = $ffmpeg->open($filename);
		
		$this->duration = $this->_video->getStreams()
			->videos()
			->first()
			->get('duration');
		
		$box = $this->_video->getStreams()
			->videos()
			->first()
			->getDimensions();
		
		$this->height = $box->getHeight();
		$this->width = $box->getWidth();
	}
	
	public function getThumb($width = null, $height = null)
	{
		if ($this->duration > 10)
		{
			$sec = 10;
		}
		else
		{
			$sec = (int)($this->duration / 2);
		}
		$temp_file = tempnam(sys_get_temp_dir(), 'thumbnail_');
		rename($temp_file, $temp_file .= '.jpg');
		
		$frame = $this->_video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
		$frame->save($temp_file);
		$thumb = (new PhotoHelper($temp_file))->getThumb($width, $height);
		
		return $thumb;
	}
}