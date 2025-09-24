<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;
use App\Common\Rules\UniqueRule as Unique;

class PlanRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', new Unique('plans', 'name', request('id'))],
            'price' => ['required', 'numeric', 'min:0.30'],
            'days' => ['required', 'integer', 'min:1'],
        ];
    }
}