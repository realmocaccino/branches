<?php
namespace App\Site\Controllers;

use App\Site\Helpers\FeedHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, View};

class FeedController extends BaseController
{
    protected $feedHelper;
    protected $itemsPerPage;

    public function __construct(FeedHelper $feedHelper, Request $request)
    {
        parent::__construct();

        $this->feedHelper = $feedHelper;
        $this->feedHelper->setFilterBy($request->filterBy);
        $this->itemsPerPage = $this->feedHelper->isReviewPage() ? config('site.feed_per_page_reviews') : config('site.feed_per_page');

        View::share('filterBy', $this->feedHelper->getFilterBy());
    }

	public function index()
	{
		$this->head->setTitle(trans('feed/index.title'));
		$this->head->setDescription(trans('feed/index.description'));

        $feed = $this->feedHelper->get()->paginate($this->itemsPerPage);

		return $this->view('feed.index', [
		    'feed' => $feed
		]);
	}
	
	public function following()
	{
	    $this->head->setTitle(trans('feed/index.title_following'));
		$this->head->setDescription(trans('feed/index.description_following'));
		
		$loggedInUser = Auth::guard('site')->user();
		$followings = $loggedInUser->followings;

        if(!count($followings)) return $this->view('feed.index', [
            'noFollowings' => true
        ]);

		$feed = $this->feedHelper->get()
            ->whereIn('user_id', $followings->pluck('id'))
            ->where('user_id', '!=', $loggedInUser->id)
            ->paginate($this->itemsPerPage);

		return $this->view('feed.index', [
		    'feed' => $feed
		]);
	}

    public function me()
    {
        $this->head->setTitle(trans('feed/index.title_me'));
        $this->head->setDescription(trans('feed/index.description_me'));

        $loggedInUser = Auth::guard('site')->user();

        $feed = $this->feedHelper->get()
            ->whereIn('user_id', $loggedInUser->id)
            ->paginate($this->itemsPerPage);

        return $this->view('feed.index', [
            'feed' => $feed
        ]);
    }
}