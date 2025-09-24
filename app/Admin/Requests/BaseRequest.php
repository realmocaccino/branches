<?php
namespace App\Admin\Requests;

use App\Common\Requests\BaseRequest as Request;

class BaseRequest extends Request
{
    public function all($keys = null)
	{
		$data = parent::all();
		
		if(!isset($data['slug']) and (isset($data['name_en']) or isset($data['name']) or isset($data['title']))) {
			$data['slug'] = str_slug($data['name_en'] ?? $data['name'] ?? $data['title'], '-');
		}
	    
		return $data;
	}
}
