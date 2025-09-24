<?php
namespace App\Admin\Helpers;

use App\Common\Helpers\Support;

class Admin
{
	public static function action($action, $route, $id)
	{
		switch($action)
		{
			case 'edit':
				$icon = 'edit';
			break;
			case 'delete':
				$icon = 'remove-circle';
			break;
			case 'finish':
				$icon = 'check';
			break;
			default:
				$icon = '';
			break;
		}
		return '<a href="'.route($route, [$id]).'" title="'.ucwords($action).'" '.($action == 'delete' ? 'data-sa' : null).'>
					<span class="glyphicon glyphicon-'.$icon.'" alt="'.ucwords($action).'"></span>
				</a>';
	}

	public static function back($route)
	{
		return Self::button($route, '<< Voltar', 'link');
	}
	
	public static function button($route, $label, $class = 'primary')
	{
		return '<a href="'.route($route).'" class="btn btn-'.$class.'">'.$label.'</a>';
	}

	public static function createMessage($class, $text)
	{
		return view('admin.components.message', [
			'class' => $class,
			'text' => $text
		]);
	}
	
	public static function date($date)
	{
		return '<span class="glyphicon glyphicon-calendar"></span> '.$date;
	}

	public static function showMessage()
	{
		if(session()->has('message'))
		{
			$message = Self::treatMessage(session('message'));
			if($message['text'])
			{
				return Self::createMessage($message['class'], $message['text']);
			}
		}
	}
	
	public static function search($placeholder, $column = 'name')
	{
		return view('admin.components.search', [
			'placeholder' => $placeholder,
			'column' => $column
		]);
	}
	
	public static function sort($sort, $label, $title)
	{
		$query_string = array_diff_key(Support::getQueryString(), array_flip(['sort', 'order']));
		
		$order = (request('sort') == $sort and request('order') == 'asc') ? 'desc' : 'asc';
		
		$url = url()->current().'?'.http_build_query(array_merge(['sort' => $sort, 'order' => $order], $query_string));
		
		return '<a href="'.$url.'" title="'.$title.'">'.$label.'</a> <span class="glyphicon glyphicon-sort"></span>';
	}
	
	public static function status($status)
	{
		return '<span class="glyphicon glyphicon-'.($status ? 'ok' : 'ban').'-circle" alt="'.($status ? 'Online' : 'Offline').'" title="'.($status ? 'Online' : 'Offline').'"></span>';
	}
	
	public static function treatMessage($string)
	{
		$defaultClass = 'info';
		$array = explode('|', $string);
		
		switch(count($array)) {
			case 2:
				return [
					'class' => $array[0] ?? $defaultClass,
					'text' => $array[1]
				];
			break;
			case 1:
				return [
					'class' => $defaultClass,
					'text' => $array[0]
				];
			break;
		}
	}
}
