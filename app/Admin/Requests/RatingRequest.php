<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;

class RatingRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'game_id' => 'required|integer',
    		'platform_id' => 'required|integer',
			'user_id' => 'required|integer'
        ];
    }
}
