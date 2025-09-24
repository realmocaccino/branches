<?php
namespace App\Site\Controllers;

use App\Common\Controllers\BaseController as Controller;
use App\Common\Helpers\Head;
use App\Site\Models\Settings;

use Detection\MobileDetect;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    private $configFile = 'site';
    protected $viewNamespace = 'site';

    protected $agent;
    protected $settings;
    protected $head;
    
    public function __construct()
    {
    	$this->agent = new MobileDetect();
    	$this->settings = (new Settings)->get();
    	$this->head = new Head();
    	
    	$this->setOgImageAndFacebookId();
        $this->shareHeadToView();
    }

    private function setOgImageAndFacebookId()
    {
        $this->head->setImage(asset('img/default-og-image.png'), 470, 470);
    	$this->head->setFacebookId(config('services.facebook.client_id'));
    }

    private function shareHeadToView()
    {
        View::share('head', $this->head);
    }

    protected function getConfiguration($configuration)
    {
        $configuration = $this->configFile . '.' . $configuration;
        $mobileConfiguration = $configuration . '_mobile';

        if($this->agent->isMobile() and config($mobileConfiguration)) {
            return config($mobileConfiguration);
        }

        return config($configuration);
    }
}