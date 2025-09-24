<?php
namespace App\Site\Requests\Account;

use App\Site\Requests\BaseRequest;
use App\Common\Rules\UniqueRule as Unique;

use Illuminate\Support\Facades\Auth;

class EditEmailRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'email' => ['required', 'confirmed', 'email', new Unique('users', 'email', Auth::guard('site')->id())],
        ];
    }
}
