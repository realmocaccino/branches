<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class PublisherRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => 'required|unique:publishers,name,'.request('id'),
			'foundation' => 'date_format:Y'
        ];
    }
}
