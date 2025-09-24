<?php
namespace App\Site\Controllers;

use App\Site\Controllers\Traits\UserPagesTrait;
use App\Site\Helpers\Filter;
use App\Site\Models\User;
use App\Site\Notifications\NewFollowerNotification;
use App\Common\Helpers\Redirect;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, View};

class UserController extends BaseController
{
	protected $filter;
	protected $isLoggedInUser;
	protected $loggedInUser;
	protected $user;

	public function __construct(Filter $filter, Request $request)
	{
		parent::__construct();

		$this->filter = $filter;
		
		$this->user = User::findBySlugOrFail($request->userSlug);
		View::share('user', $this->user);
		
		$this->middleware(function($request, $next) {
		    $this->loggedInUser = Auth::guard('site')->user();
		    View::share('loggedInUser', $this->loggedInUser);
		
			$this->isLoggedInUser = (optional($this->loggedInUser)->id == $this->user->id);
			View::share('isLoggedInUser', $this->isLoggedInUser);
			
			$followsYou = $this->user->isFollowing($this->loggedInUser);
			View::share('followsYou', $followsYou);
			
			if($this->loggedInUser and !$this->isLoggedInUser) {
				View::share('totalCommonRatings', $this->user->commonRatings($this->loggedInUser)->count());
			}

			View::share('totalCollections', $this->user->collections()->when(!$this->isLoggedInUser, function($query) {
			    return $query->notPrivate()->withGames();
			})->count());
			
			return $next($request);
		});
	}
	
	public function follow()
	{
	    if(!$this->user->isFollowedBy($this->loggedInUser)) {
	        $this->loggedInUser->follow($this->user);
	        
	        $this->user->notify(new NewFollowerNotification($this->loggedInUser));
	    }
	    
	    if(Redirect::checkIfThereIsPreviousURL()) {
			return redirect(Redirect::getThenForgetPreviousURL());
		} else {
			return back();
		}
	}
	
	public function unfollow()
	{
	    $this->loggedInUser->unfollow($this->user);
	    
	    return back();
	}

	use UserPagesTrait;
}