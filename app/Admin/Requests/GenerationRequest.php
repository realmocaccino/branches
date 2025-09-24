<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class GenerationRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|unique:generations,name,'.request('id'),
			'name_en' => 'required|unique:generations,name_en,'.request('id'),
			'name_es' => 'required|unique:generations,name_es,'.request('id'),
			'name_fr' => 'required|unique:generations,name_fr,'.request('id'),
			'interval' => 'required'
        ];
    }
}
