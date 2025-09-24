<?php
namespace App\Common\Helpers;

class Number
{
	public static $romans = [
		'M' => 1000,
		'CM' => 900,
		'D' => 500,
		'CD' => 400,
		'C' => 100,
		'XC' => 90,
		'L' => 50,
		'XL' => 40,
		'X' => 10,
		'IX' => 9, 
		'V' => 5,
		'IV' => 4,
		'I' => 1
	];

	public static function checkArabic($string)
	{
		return preg_match('!\d+!', $string);
	}
	
	public static function checkRoman($string)
	{
		return preg_match('^(?:XL|L|L?(?:IX|X{1,3}|X{0,3}(?:IX|IV|V|V?I{1,3})))^', $string);
	}
	
	public static function getArabicOccurrence($string)
	{
		preg_match('!\d+!', $string, $match);
		
		return $match;
	}
	
	public static function getRomanOccurrence($string)
	{
		preg_match("^(?:XL|L|L?(?:IX|X{1,3}|X{0,3}(?:IX|IV|V|V?I{1,3})))^", $string, $match);
		
		return $match;
	}
	
	public static function arabic2roman($string)
	{
		if(Self::checkArabic($string)) {
			$match = Self::getArabicOccurrence($string);
		
			$match = $match[0];
			$auxMatch = $match;
			
			$return = '';
			
			while($match > 0)
			{
				foreach(Self::$romans as $roman => $arabic)
				{
				    if($match >= $arabic)
				    {
				        $match -= $arabic;
				        $return .= $roman;
				        
				        break;
				    } 
				} 
			}
			
			return str_replace($auxMatch, $return, $string);
		} else {
			return $string;
		}
	}
	
	public static function roman2arabic($string)
	{
		if(Self::checkRoman($string)) {
			$match = Self::getRomanOccurrence($string);
		
			$roman = $match[0];

			$arabic = '';
			
			foreach (Self::$romans as $chave => $valor)
			{
				while (strpos($roman, $chave) === 0)
				{
					$arabic += $valor;
					$roman = substr($roman, strlen($chave));
				}
			}
			
			return $arabic;
		} else {
			return $string;
		}
	}
}
