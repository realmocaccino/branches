<?php
namespace App\Common\Helpers;

use App\Site\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;
use Str;

class Support
{
	public static $modelPath = 'App\\Common\\Models\\';
	
	public static function arrayDiffAssocMulti($array1, $array2)
	{
		$result = [];

		foreach($array1 as $key => $val) {
			if(is_array($val) and isset($array2[$key])) {
				$tmp = self::arrayDiffAssocMulti($val, $array2[$key]);
				
				if($tmp) $result[$key] = $tmp;
			} elseif(!isset($array2[$key])) {
				$result[$key] = null;
			} elseif($val != $array2[$key]) {
				$result[$key] = $array2[$key];
			}

			if(isset($array2[$key])) {
				unset($array2[$key]);
			}
		}

		$result = array_merge($result, $array2);

		return $result;
	}

    public static function array2object($array)
    {
        $object = new \stdClass();

        foreach($array as $key => $value) {
            if(is_array($value)) {
                $value = self::array2object($value);
            }

            $object->$key = $value;
        }

        return $object;
    }

	public static function createUserSlug($name, $iterator = 0)
	{
		$complement = ($iterator) ? '-' . $iterator : null;
		
		$slug = str_slug($name . $complement, '-');

		if(User::whereSlug($slug)->first()) {
			return self::createUserSlug($name, ++$iterator);
		} else {
			return $slug;
		}
	}
	
	public static function dateToMiliseconds($date = null)
	{
		return round(($date ? strtotime($date) : microtime(true)) * 1000);
	}
	
	public static function extractIdFromYoutubeURL($url)
	{
		preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
		
		return $matches[0] ?? $url;
	}

	public static function getDateFromString($datetimeString)
	{
		$pattern = '/(\d{1,4}[\/\-]\d{1,2}[\/\-]\d{1,4})/';

		if (preg_match($pattern, $datetimeString, $matches)) {
			return $matches[1];
		}

		throw new InvalidArgumentException();
	}

    public static function getLocalizatedColumn($model, $column)
    {
		$table = is_string($model) ? app($model)->getTable() : $model->getTable();
        $localizedColumn = $column . config('site.locale_column_suffix');

        if(Schema::hasColumn($table, $localizedColumn)) {
            return $localizedColumn;
        }

        return $column;
    }
	
	public static function getModelInstanceByTableName($name)
	{
		$model = Self::$modelPath . Str::studly(Str::singular($name));
	
    	return (new $model);
	}
	
	public static function getQueryString($key = null)
	{
		$url = parse_url(url()->full());
		
		if(isset($url['query']))
		{
			parse_str($url['query'], $queryString);
			
			return $key ? ($queryString[$key] ?? null) : $queryString;
		}
		else
		{
			return $key ? null : [];
		}
	}

	public static function getYearFromDate($date)
	{
		return self::parseDate($date)->format('Y');
	}

	public static function isAbsolute($url)
	{
		return (bool) (strstr($url, 'http') or strstr($url, 'https'));
	}

	public static function isYear($input) {
        return preg_match('/^\d{4}$/', $input) === 1;
    }
	
	public static function milisecondsToDate($miliseconds, $dateFormat = 'Y-m-d')
	{
		return gmdate($dateFormat, $miliseconds / 1000);
	}

	public static function parseDate($date)
	{
		$date = self::getDateFromString($date);

		if(strstr($date, '/')) {
			return Carbon::createFromFormat('d/m/Y', $date);
		}

		if(strstr($date, '-')) {
			return Carbon::createFromFormat('Y-m-d', $date);
		}

		throw new InvalidArgumentException();
	}
	
	public static function removeDateFromString($string)
	{
		return trim(preg_replace('/(\([0-3]\d\/[01]\d\/\d{4}\))/', '', $string));
	}

	public static function removeNonAlphanumeric($string)
	{
		return trim(preg_replace('/[^a-zA-Z0-9\s]/', '', $string));
	}
	
	public static function unixTimestampToDate($unixtime, $dateFormat = 'Y-m-d')
	{
		return gmdate($dateFormat, $unixtime);
	}

	public static function searchArrayOfObjects($array, $property, $value)
	{
		return array_filter(
			$array,
			function ($e) use ($property, $value) {
				return strcasecmp($e->{$property}, $value) === 0;
			}
		);
	}
}