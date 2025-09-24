<?php
namespace App\Admin\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Common\Controllers\BaseController as Controller;
use App\Common\Helpers\Head;
use App\Admin\Models\Settings;

class BaseController extends Controller
{
    protected $head;
    protected $settings;
    
    public function __construct()
    {
    	$this->viewNamespace = 'admin';
    
    	$this->head = new Head();
    	$this->settings = (new Settings)->get();
    	
    	View::share('head', $this->head);
    	View::share('settings', $this->settings);
    	
    	$this->middleware(function ($request, $next)
    	{
			$permission = Auth::guard('admin')->user();
			View::share('permission', $permission);
            return $next($request);
        });
    }
}
