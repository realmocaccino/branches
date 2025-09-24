<?php
namespace App\Common\Helpers;

class Redirect
{
	public static function getSessionName($guard)
	{
		return $guard . '_intended_url';
	}

	public static function putSession($guard, $url = null)
	{
		session()->put(self::getSessionName($guard), $url ?? str_replace(url('/'), '', url()->full()));
	}

	public static function forgetSession($guard)
	{
		session()->forget(self::getSessionName($guard));
	}
	
	public static function checkIfThereIsIntendedURL($guard)
	{
		return self::getIntendedURL($guard);
	}
	
	public static function getIntendedURL($guard)
	{
		$url = session(self::getSessionName($guard));
		
		return $url ? (!request()->ajax() ? str_replace(['ajax/', '/ajax'], '', $url) : $url) : null;
	}
	
	public static function getThenForgetIntendedURL($guard)
	{
		$intendedUrl = self::getIntendedURL($guard);
		self::forgetSession($guard);
	
		return $intendedUrl;
	}
	
	public static function savePreviousURL()
	{
	    session()->put('previous_url', str_replace(url('/'), '', url()->previous()));
	}
	
	public static function getPreviousURL()
	{
		return session('previous_url');
	}
	
	public static function forgetPreviousURL()
	{
		session()->forget('previous_url');
	}
	
	public static function checkIfThereIsPreviousURL()
	{
		return self::getPreviousURL();
	}
	
	public static function getThenForgetPreviousURL()
	{
		$previousURL = self::getPreviousURL();
		self::forgetPreviousURL();
	
		return $previousURL;
	}
}