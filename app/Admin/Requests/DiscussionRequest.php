<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class DiscussionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'title' => 'required',
			'text' => 'required'
        ];
    }
}