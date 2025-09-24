<?php
namespace App\Common\Presenters;

use Storage;

trait ScreenshotPresenter
{
	use BasePresenter;
	
	public $uploadStorageFolder = [
		'filename' => 'game/screenshot'
	];
	
    public $uploadDimensions = [
		'filename' => [
			['width' => 92, 'height' => 52],
			['width' => 277, 'height' => 157],
			['width' => 640, 'height' => 360],
			['width' => 1280, 'height' => 720]
		]
	];
	
	public function getScreenshot($dimensionFolder = '1280x720')
	{
		return ($this->filename) ? asset(Storage::url(implode('/', [$this->uploadStorageFolder['filename'], $dimensionFolder, $this->filename]))) : null;
	}
	
	public function uploadAndHandleFilename($filename)
	{
		return $this->uploadFile('filename', str_replace(' ', '%20', $filename));
	}
}