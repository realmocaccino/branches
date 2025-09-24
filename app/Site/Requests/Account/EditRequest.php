<?php
namespace App\Site\Requests\Account;

use App\Site\Requests\BaseRequest;
use App\Common\Rules\UniqueRule as Unique;

use Illuminate\Support\Facades\Auth;
class EditRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'name' => 'required|min:3',
        	'slug' => ['required', 'alpha_dash', 'min:3', new Unique('users', 'slug', Auth::guard('site')->id())],
        	'password' => 'min:6',
            'mode' => 'required|in:dark,light',
        ];
    }
}
