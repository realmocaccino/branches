<?php
namespace App\Site\Presenters;

use App\Site\Models\Collection;

trait UserCollectionPresenter
{
	public function createCollection($listName)
	{
		return Collection::firstOrCreate(['name' => $listName, 'slug' => str_slug($listName), 'user_id' => $this->id]);
	}

	public function playingGames()
	{
		return Collection::firstOrCreate(['slug' => 'playing', 'user_id' => $this->id])->games();
	}
	
	public function favoriteGames()
	{
		return Collection::firstOrCreate(['slug' => 'favorites', 'user_id' => $this->id])->games();
	}
	
	public function wishlistGames()
	{
		return Collection::firstOrCreate(['slug' => 'wishlist', 'user_id' => $this->id])->games();
	}
}