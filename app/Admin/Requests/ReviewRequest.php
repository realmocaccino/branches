<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class ReviewRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'text' => 'required|min:100'
        ];
    }
}
