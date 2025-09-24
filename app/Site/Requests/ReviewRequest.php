<?php
namespace App\Site\Requests;

class ReviewRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'text' => 'required|min:' . config('site.minimum_characters_to_review') . '|max:10000'
        ];
    }
}
