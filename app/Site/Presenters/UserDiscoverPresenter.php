<?php
namespace App\Site\Presenters;

use App\Site\Repositories\UserRepository;

trait UserDiscoverPresenter
{
	private const SCORE_THRESHOLD = 0.0;
	private const TOTAL_CHARACTERISTICS = 5;
    private const TOTAL_DISCOVERABLE_GAMES = 100;
	private const TOTAL_GENRES = 8;
	private const TOTAL_THEMES = 3;

	public function getDiscoverableGames()
	{
        return UserRepository::getDiscoverableGames(
            $this->id,
            self::TOTAL_DISCOVERABLE_GAMES,
            $this->getFavoriteCharacteristics(),
            $this->getFavoriteGenres(),
            $this->getFavoriteThemes()
        );
	}

    public function getFavoriteCharacteristics()
	{
		if ($characteristics = UserRepository::getFavoriteCharacteristicsByFavorites($this->id, self::TOTAL_CHARACTERISTICS) and $characteristics->count()) {
			return $characteristics;
		}

        return UserRepository::getFavoriteCharacteristicsByRatings($this->id, self::SCORE_THRESHOLD, self::TOTAL_CHARACTERISTICS);
	}

	public function getFavoriteGenres()
	{
		if ($genres = UserRepository::getFavoriteGenresByFavorites($this->id, self::TOTAL_GENRES) and $genres->count()) {
			return $genres;
		}

        return UserRepository::getFavoriteGenresByRatings($this->id, self::SCORE_THRESHOLD, self::TOTAL_GENRES);
	}

	public function getFavoriteThemes()
	{
        if ($themes = UserRepository::getFavoriteThemesByFavorites($this->id, self::TOTAL_THEMES) and $themes->count()) {
			return $themes;
		}

        return UserRepository::getFavoriteThemesByRatings($this->id, self::SCORE_THRESHOLD, self::TOTAL_THEMES);
	}
}