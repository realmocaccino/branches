<?php
namespace App\Site\Requests\Account;

use App\Site\Requests\BaseRequest;

class UploadBackgroundRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'background' => 'required|image|max:5000'
        ];
    }
}