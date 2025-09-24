<?php
namespace App\Site\Controllers\Ajax;

use App\Common\Controllers\BaseController as Controller;
use App\Site\Models\Settings;

use MobileDetect;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    protected $agent;
    protected $settings;
    
    public function __construct()
    {
    	$this->viewNamespace = 'site.ajax';
    	
    	$this->agent = new MobileDetect();
    	$this->settings = (new Settings)->get();
    }
}