<?php
namespace App\Console\Actions\Misc;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class NewImageSize
{
	protected $basePath;
	protected $newSize;
	protected $newSizeFolder;
	protected $mirrorFiles;
	protected $quality;

	public function __construct($basePath, $mirrorFolder, $newDimension, $quality = 90)
	{
		$this->basePath = $basePath;
		$this->dimensions = explode('x', $newDimension);
		$this->newSizeFolder = $basePath . '/' . $newDimension;
		$this->mirrorFiles = Storage::files($basePath . '/' . $mirrorFolder);
		$this->quality = $quality;

		$this->makeNewSizeDirectory();
	}
	
	protected function makeNewSizeDirectory()
	{
		return Storage::makeDirectory($this->newSizeFolder);
	}
	
	public function create()
	{
		foreach($this->mirrorFiles as $filename) {
			Image::make(storage_path('app/public/' . $filename))
			->resize($this->dimensions[0], $this->dimensions[1], function($constraint) {
                return !$this->dimensions[1] ? $constraint->aspectRatio() : null;
            })
			->save(storage_path('app/public/' . $this->newSizeFolder . '/' . basename($filename)), $this->quality);
		}
	}
}