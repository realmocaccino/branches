<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class GenreRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name_pt' => 'required|unique:genres,name_pt,'.request('id'),
			'name_en' => 'required|unique:genres,name_en,'.request('id'),
			'name_es' => 'required|unique:genres,name_es,'.request('id'),
			'name_fr' => 'required|unique:genres,name_fr,'.request('id'),
        ];
    }
}
