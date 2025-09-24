<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class ModeRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name_pt' => 'required|unique:modes,name_pt,'.request('id'),
			'name_en' => 'required|unique:modes,name_en,'.request('id'),
			'name_es' => 'required|unique:modes,name_es,'.request('id'),
			'name_fr' => 'required|unique:modes,name_fr,'.request('id'),
        ];
    }
}
