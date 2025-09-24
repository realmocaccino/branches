<?php
namespace App\Site\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationsController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware(function($request, $next) {
			$this->user = Auth::guard('site')->user();
			
			return $next($request);
		});
		
		$this->head->disableSearchIndexing();
	}
	
	public function index()
	{
		$this->head->setTitle(trans('notifications/index.title'));
		
		return $this->view('notifications.index', [
			'user' => $this->user,
			'notifications' => $this->user->notifications()->paginate(20)
		]);
	}
}
