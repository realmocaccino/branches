<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class SubscriptionRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}