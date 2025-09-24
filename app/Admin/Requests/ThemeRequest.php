<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class ThemeRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name_pt' => 'required|unique:themes,name_pt,'.request('id'),
			'name_en' => 'required|unique:themes,name_en,'.request('id'),
			'name_es' => 'required|unique:themes,name_es,'.request('id'),
			'name_fr' => 'required|unique:themes,name_fr,'.request('id'),
        ];
    }
}
