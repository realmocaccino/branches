<?php
namespace App\Site\Requests;

class RatingRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'criterias.*' => 'required|numeric|min:0|max:10',
			'platform_id' => 'required|integer'
        ];
    }
}
