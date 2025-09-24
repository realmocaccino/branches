<?php
namespace App\Site\Requests;

use App\Common\Rules\UniqueRule as Unique;

class PremiumRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'planId' => 'required',
            'token' => ['required', new Unique('subscriptions', 'token', $this->token)]
        ];
    }
}