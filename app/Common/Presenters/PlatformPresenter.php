<?php
namespace App\Common\Presenters;

use Storage;

trait PlatformPresenter
{
	use BasePresenter;
	
	public $uploadStorageFolder = [
		'logo' => 'platform/logo'
	];
	
    public $uploadDimensions = [
    	'logo' => [
			['width' => 16, 'height' => 16],
			['width' => 20, 'height' => 20],
			['width' => 32, 'height' => 32],
			['width' => 64, 'height' => 64]
		]
	];
	
	public function getLogo($dimensionFolder = '32x32')
	{
		return ($this->logo) ? asset(Storage::url(implode('/', [$this->uploadStorageFolder['logo'], $dimensionFolder, $this->logo]))) : null;
	}
}