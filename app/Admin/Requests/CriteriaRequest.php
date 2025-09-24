<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class CriteriaRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name_pt' => 'required|unique:criterias,name_pt,'.request('id'),
			'name_en' => 'required|unique:criterias,name_en,'.request('id'),
			'name_es' => 'required|unique:criterias,name_es,'.request('id'),
			'name_fr' => 'required|unique:criterias,name_fr,'.request('id'),
			'weight' => 'required'
        ];
    }
}
