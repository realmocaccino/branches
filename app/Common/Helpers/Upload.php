<?php
namespace App\Common\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class Upload
{
	protected $model;
	protected $field;
	protected $extension = 'jpg';
	protected $defaultQuality = 85;

	public function __construct($model, $field)
	{
		$this->model = $model;
		$this->field = $field;
	}
	
	public function store($fileRequest, $extension = null)
	{
		$filename = $this->model->getAttribute($this->field);
		
		if($extension) $this->extension = $extension;
		
		if(!$filename or $extension) {
			$filename = uniqid() . '.' . $this->extension;
			$this->storeOnDatabase($filename);
		}
		
		foreach($this->model->uploadDimensions[$this->field] as $dimension) {
			$this->storeOnDisk($fileRequest, $filename, $dimension);
		}
		
		return $filename;
	}
	
	
	public function storeOnDatabase($filename)
	{
		$this->model->setAttribute($this->field, $filename);
		$this->model->save();
	}
	
	public function storeOnDisk($fileRequest, $filename, $dimension)
	{
		$directory = storage_path('app/public/' . implode('/', [$this->model->uploadStorageFolder[$this->field], $this->getDimensionDirectoryName($dimension)]));
		
		if(!file_exists($directory)) mkdir($directory, 0775, true);
		
		$image = Image::make((gettype($fileRequest) == 'object') ? $fileRequest->getRealPath() : $fileRequest)->encode($this->extension);
		
		if(isset($dimension['height'])) {
			$image->fit($dimension['width'], $dimension['height'], null, 'center');
		} else {
			$image->resize($dimension['width'], null, function($constraint) {
				$constraint->aspectRatio();
			});
		}
		
		$image->save($directory . '/' . $filename, ($dimension['quality'] ?? $this->defaultQuality));
	}
	
	public function delete()
	{
		$filename = $this->model->getAttribute($this->field);
	
		$this->deleteFromDatabase();
		
		if($filename) {
			foreach($this->model->uploadDimensions[$this->field] as $dimension) {
				$this->deleteOnDisk($filename, $dimension);
			}
		}
	}
	
	public function deleteFromDatabase()
	{
		$this->model->setAttribute($this->field, null);
		$this->model->save();
	}
	
	public function deleteOnDisk($filename, $dimension)
	{
		$filepath = storage_path('app/public/' . implode('/', [$this->model->uploadStorageFolder[$this->field], $this->getDimensionDirectoryName($dimension), $filename]));
		
		if(File::exists($filepath)) File::delete($filepath);
	}
	
	protected function getDimensionDirectoryName($dimension)
	{
		return $dimension['width'] . 'x' . ($dimension['height'] ?? null);
	}
}
