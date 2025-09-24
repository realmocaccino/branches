<?php
namespace App\Site\Helpers;

class Alert
{
	public static function check()
	{
		if(session()->has('alert')) {
			$alert = Self::treat(session('alert'));
		
			if($alert['text']) return Self::create($alert['className'], $alert['text'], $alert['autoClose']);
		}
		
		return null;
	}

	public static function create($className, $text, $autoClose = true)
	{
		return view('site.helpers.alert', [
			'className' => $className,
			'text' => $text,
			'autoClose' => $autoClose
		]);
	}
	
	public static function treat($string)
	{
		$defaultClassName = 'info';
		$defaultAutoClose = true;
		
		$array = explode('|', $string);
		
		return [
			'className' => (isset($array[1]) ? $array[0] : $defaultClassName),
			'text' => (isset($array[1]) ? $array[1] : $array[0]),
			'autoClose' => (isset($array[2]) ? filter_var($array[2], FILTER_VALIDATE_BOOLEAN) : $defaultAutoClose)
		];
	}
}
