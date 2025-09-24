<?php
namespace App\Admin\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
	public function index()
	{
		$this->head->setTitle('Dashboard');
		
		return $this->view('home.index', [
			'total' => [
				'contributions'   => DB::table('contributions')->whereNull('deleted_at')->count(),
				'editionRequests' => DB::table('edition_requests')->whereNull('deleted_at')->count(),
				'characteristics' => DB::table('characteristics')->whereNull('deleted_at')->count(),
				'classifications' => DB::table('classifications')->whereNull('deleted_at')->count(),
				'developers' 	  => DB::table('developers')->whereNull('deleted_at')->count(),
				'manufacturers'   => DB::table('manufacturers')->whereNull('deleted_at')->count(),
				'franchises'	  => DB::table('franchises')->whereNull('deleted_at')->count(),
				'genres'		  => DB::table('genres')->whereNull('deleted_at')->count(),
				'generations' 	  => DB::table('generations')->whereNull('deleted_at')->count(),
				'games' 		  => DB::table('games')->whereNull('deleted_at')->count(),
				'modes' 		  => DB::table('modes')->whereNull('deleted_at')->count(),
				'platforms' 	  => DB::table('platforms')->whereNull('deleted_at')->count(),
				'publishers' 	  => DB::table('publishers')->whereNull('deleted_at')->count(),
				'themes'		  => DB::table('themes')->whereNull('deleted_at')->count(),
				'ratings'         => DB::table('ratings')->whereNull('deleted_at')->count(),
				'reviews'         => DB::table('reviews')->whereNull('deleted_at')->count(),
				'criterias'       => DB::table('criterias')->whereNull('deleted_at')->count(),
				'banners' 	  	  => DB::table('banners')->whereNull('deleted_at')->count(),
				'news' 	  		  => DB::table('news')->whereNull('deleted_at')->count(),
				'links'			  => DB::table('links')->whereNull('deleted_at')->count(),
				'menus'			  => DB::table('menus')->whereNull('deleted_at')->count(),
				'institutionals'  => DB::table('institutionals')->whereNull('deleted_at')->count(),
				'rules'     	  => DB::table('rules')->whereNull('deleted_at')->count(),
				'contacts'        => DB::table('contacts')->whereNull('deleted_at')->count(),
				'administrators'  => DB::table('administrators')->whereNull('deleted_at')->count(),
				'roles' 		  => DB::table('roles')->whereNull('deleted_at')->count(),
				'users' 		  => DB::table('users')->whereNull('deleted_at')->count(),
                'plans'           => DB::table('plans')->whereNull('deleted_at')->count(),
				'subscriptions'   => DB::table('subscriptions')->whereNull('deleted_at')->count(),
				'advertisements'  => DB::table('advertisements')->whereNull('deleted_at')->count(),
				'advertisers' 	  => DB::table('advertisers')->whereNull('deleted_at')->count(),
				'discussions'	  => DB::table('discussions')->whereNull('deleted_at')->count(),
				'answers'	      => DB::table('answers')->whereNull('deleted_at')->count(),
			]
		]);
	}
}