<?php
namespace App\Site\Requests\Collection;

use App\Site\Requests\BaseRequest;

class EditRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'name' => 'required|min:2'
        ];
    }
}