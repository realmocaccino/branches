<?php
namespace App\Site\Controllers\Ajax;

use App\Site\Helpers\Alert;

use Illuminate\Http\Request;

class AlertController extends BaseController
{
	public function index(Request $request)
	{
		if($request->has(['className', 'text'])) {
			return Alert::create($request->className, $request->text);
		}
	}
}
