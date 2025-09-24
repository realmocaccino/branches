<?php
namespace App\Site\Controllers;

use App\Site\Helpers\DiscoverHelper;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class DiscoverController extends BaseController
{
    private $authentication;
    private $discoverHelper;
    private $perPage;

    public function __construct(AuthManager $authentication, DiscoverHelper $discoverHelper)
    {
        parent::__construct();

        $this->authentication = $authentication;
        $this->discoverHelper = $discoverHelper;
        $this->perPage = $this->getConfiguration('per_page');
    }

    public function index(Request $request)
    {
        $this->head->setTitle(trans('discover/index.title'));
        $this->head->setDescription(trans('discover/index.description'));

        if($activeKeywords = $request->keywords) {
            $games = $this->discoverHelper->getGamesFromKeywords($activeKeywords, $this->perPage);

            return $this->view('listing.games', [
                'activeKeywords' => $activeKeywords,
                'keywords' => $this->discoverHelper->getAllKeywords(),
                'items' => $games,
                'total' => !$this->agent->isMobile() ? $games->total() : null
            ]);
        }
        
        if($user = $this->authentication->guard('site')->user() and $list = $this->discoverHelper->getUserList($user)) {
            return $this->view('listing.games', [
                'keywords' => $this->discoverHelper->getAllKeywords(),
                'favorites' => $user->favoriteTags(),
                'items' => $list
            ]);
        }

        return $this->view('listing.games', [
            'keywords' => $this->discoverHelper->getAllKeywords(),
            'items' => $this->discoverHelper->getDefaultList($this->perPage)
        ]);
    }
}