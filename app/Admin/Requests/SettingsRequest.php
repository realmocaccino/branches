<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class SettingsRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'url' => 'required|url',
			'name' => 'required',
			'description_pt' => 'required',
			'description_en' => 'required',
			'description_es' => 'required',
			'description_fr' => 'required',
			'email' => 'required|email'
        ];
    }
}
