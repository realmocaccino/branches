<?php
namespace App\Admin\Requests;

use App\Admin\Requests\BaseRequest;
use App\Common\Rules\UniqueRule as Unique;

class LinkRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        	'menu_id' => 'required',
			'name_pt' => ['required', (new Unique('links', 'name_pt'))->withFurtherCondition('menu_id', '=', request('menu_id'))],
			'name_en' => ['required', (new Unique('links', 'name_en'))->withFurtherCondition('menu_id', '=', request('menu_id'))],
			'name_es' => ['required', (new Unique('links', 'name_es'))->withFurtherCondition('menu_id', '=', request('menu_id'))],
			'name_fr' => ['required', (new Unique('links', 'name_fr'))->withFurtherCondition('menu_id', '=', request('menu_id'))],
        ];
    }
}
