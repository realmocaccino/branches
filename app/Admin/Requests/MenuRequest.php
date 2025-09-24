<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class MenuRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|unique:menus,name,'.request('id'),
        ];
    }
}
