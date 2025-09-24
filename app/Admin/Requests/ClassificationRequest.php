<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class ClassificationRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|unique:classifications,name,'.request('id')
        ];
    }
}
