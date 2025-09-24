<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class ManufacturerRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|unique:manufacturers,name,'.request('id'),
			'foundation' => 'numeric'
        ];
    }
}
