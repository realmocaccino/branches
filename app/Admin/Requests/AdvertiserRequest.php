<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class AdvertiserRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|unique:advertisers,name,'.request('id')
        ];
    }
}
