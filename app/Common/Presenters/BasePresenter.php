<?php
namespace App\Common\Presenters;

use App\Common\Helpers\Upload;

use Illuminate\Support\Facades\Schema;

trait BasePresenter
{
	public function deleteFile($field)
	{
		$cover = new Upload($this, $field);
		$cover->delete();
	}

	public static function findBySlug($slug)
	{
		if(Schema::hasColumn((new Self)->getTable(), 'slug')) {
			return Self::whereSlug($slug)->first();
		} else {
			return null;
		}
	}
	
	public static function findBySlugOrFail($slug)
	{
		if(Schema::hasColumn((new Self)->getTable(), 'slug')) {
			return Self::whereSlug($slug)->firstOrFail();
		} else {
			return null;
		}
	}
	
	public function uploadFile($field, $fileRequest, $extension = null)
	{
		$upload = new Upload($this, $field);
		$upload->store($fileRequest, $extension);
	}
}
