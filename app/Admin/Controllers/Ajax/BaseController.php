<?php
namespace App\Admin\Controllers\Ajax;

use Illuminate\Support\Facades\View;

use App\Common\Controllers\BaseController as Controller;
use App\Admin\Models\Settings;

class BaseController extends Controller
{
    protected $settings;
    
    public function __construct()
    {
    	$this->viewNamespace = 'admin.ajax';
    
    	$this->settings = (new Settings)->get();
    	
    	View::share('settings', $this->settings);
    }
}
