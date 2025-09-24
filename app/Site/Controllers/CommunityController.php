<?php
namespace App\Site\Controllers;

use App\Site\Helpers\CommunityHelper;

class CommunityController extends BaseController
{
	protected $communityHelper;

	public function __construct(CommunityHelper $communityHelper)
    {
        parent::__construct();

        $this->communityHelper = $communityHelper;
    }

	public function index()
	{
		$this->head->setTitle(trans('community/index.title'));
		$this->head->setDescription(trans('community/index.description'));

		return $this->view('community.index', [
		    'startingPosition' => 0,
			'anticipatedGames' => $this->communityHelper->getAnticipatedGames(),
		    'collections' => $this->communityHelper->getCollections(),
		    'contributions' => $this->communityHelper->getContributions(),
			'discussions' => $this->communityHelper->getDiscussions(),
			'playingNowGames' => $this->communityHelper->getPlayingNowGames(),
		    'ratings' => $this->communityHelper->getRatings(),
		    'reviews' => $this->communityHelper->getReviews(),
			'spotlightUsers' => $this->communityHelper->getSpotlightUsers()
		]);
	}
}