<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class RoleRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|alpha|unique:roles,name,'.request('id')
        ];
    }
}
