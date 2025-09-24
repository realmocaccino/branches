<?php
namespace App\Site\Helpers;

use App\Site\Models\Advertisement;
use App\Site\Helpers\Site;

use Detection\MobileDetect;
use Illuminate\Support\Facades\Auth;

class Ad
{
	public static $advertiserScriptAlreadyIncluded = [];

    public static function exists($slug)
    {
        return (bool) self::getAd($slug);
    }

	public static function show($slug)
	{
	    $ad = self::getAd($slug);
	
		return $ad ? view('site.helpers.ad', [
	        'local' => (config('app.env') == 'local'),
	        'advertiserScript' => self::getAdvertiserScript($ad),
	        'code' => $ad->analytics,
	        'responsive' => $ad->responsive,
	        'width' => $ad->width,
	        'height' => $ad->height,
	        'style' => $ad->style
        ]) : null;
	}
	
	private static function checkPlatform($platform)
	{
		if($platform == '') {
			return true;
		} else {
			$agent = new MobileDetect();
	
			switch($platform) {
				case 'desktop':
					return (!$agent->isMobile());
				break;
				case 'mobile':
					return ($agent->isMobile());
				break;
				default:
					return false;
			    break;
			}
		}
	}
	
	private static function getAd($slug)
	{
	    if(Site::canShowAd()) {
			$ad = Advertisement::whereSlug($slug)->whereHas('advertiser')->first();
			
			if($ad and self::checkPlatform($ad->platform)) {
			    return $ad;
		    }
		    
		    return null;
		}
		
		return null;
	}
	
	private static function getAdvertiserScript($ad)
	{
		$advertiserScript = null;
		
		if($ad->advertiser->analytics and !isset(self::$advertiserScriptAlreadyIncluded[$ad->advertiser->slug])) {
			$advertiserScript = $ad->advertiser->analytics;
			
			self::$advertiserScriptAlreadyIncluded[$ad->advertiser->slug] = true;
		}
		
		return $advertiserScript;
	}
}