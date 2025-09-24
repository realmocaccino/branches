<?php
namespace App\Site\Requests\Account;

use App\Site\Requests\BaseRequest;

class UploadPictureRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'picture' => 'required|image|max:5000'
        ];
    }
}