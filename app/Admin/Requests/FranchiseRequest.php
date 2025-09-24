<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;
use App\Common\Rules\UniqueRule as Unique;

class FranchiseRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'name' => ['required', new Unique('franchises', 'name', request('id'))]
        ];
    }
}