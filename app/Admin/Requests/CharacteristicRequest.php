<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class CharacteristicRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name_pt' => 'required|unique:characteristics,name_pt,'.request('id'),
			'name_en' => 'required|unique:characteristics,name_en,'.request('id'),
			'name_es' => 'required|unique:characteristics,name_es,'.request('id'),
			'name_fr' => 'required|unique:characteristics,name_fr,'.request('id'),
        ];
    }
}
