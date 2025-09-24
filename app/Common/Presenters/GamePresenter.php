<?php
namespace App\Common\Presenters;

use Storage;
use Carbon;

trait GamePresenter
{
	use BasePresenter;
	
	public $uploadStorageFolder = [
		'background' => 'game/background',
		'cover' => 'game/cover'
	];
	
    public $uploadDimensions = [
    	'background' => [
			['width' => 1920, 'height' => 1080, 'quality' => 50],
			['width' => 1280, 'height' => 720, 'quality' => 50],
			['width' => 576, 'height' => 324, 'quality' => 72]
		],
		'cover' => [
			['width' => 48, 'height' => 60],
			['width' => 78, 'height' => 90],
			['width' => 110, 'height' => 136],
			['width' => 150, 'height' => 185],
			['width' => 210],
			['width' => 250, 'quality' => 90],
			['width' => 350, 'quality' => 85]
		]
	];
	
	public function countdownByDays()
	{
		return ($this->release) ? $this->release->diffInDays(Carbon::today()) : null;
	}
	
	public function getAllAttributes()
	{
		$allAttributes = $this->getAttributes() +
			['characteristics' => $this->characteristics->pluck('id')->all()] +
			['developers' => $this->developers->pluck('id')->all()] +
			['franchises' => $this->franchises->pluck('id')->all()] +
			['genres' => $this->genres->pluck('id')->all()] +
			['modes' => $this->modes->pluck('id')->all()] +
			['platforms' => $this->platforms->pluck('id')->all()] +
			['publishers' => $this->publishers->pluck('id')->all()] +
			['themes' => $this->themes->pluck('id')->all()] +
			['classification' => ($this->classification) ? $this->classification->id : ''];
		$allAttributes['release'] = optional($this->release)->format('d/m/Y');
		
		return $allAttributes;
	}
	
	public function getBackground($dimensionFolder = '1920x1080')
	{
		return ($this->background) ? asset(Storage::url(implode('/', [$this->uploadStorageFolder['background'], $dimensionFolder, $this->background]))) : null;
	}
	
	public function getCover($dimensionFolder = '250x', $noCoverImage = true)
	{
		return ($this->cover) ? asset(Storage::url(implode('/', [$this->uploadStorageFolder['cover'], $dimensionFolder, $this->cover]))) : ($noCoverImage ? asset('img/no-cover.jpg') : null);
	}

    public function uploadCover($cover)
    {
    	$this->uploadFile('cover', $cover);
    }

    public function uploadBackground($background)
    {
    	$this->uploadFile('background', $background);
    }
	
	public function isAvailable()
	{
		return ($this->release and $this->release->isPast());
	}
	
	public function isClassic()
	{
		return ($this->release and $this->release->lt(Carbon::parse(config('site.classic_game_date'))));
	}

	public function isComing()
	{
		return ($this->release and $this->release->isFuture());
	}

	public function isEarlyAccess()
	{
		return $this->is_early_access;
	}
	
	public function isExclusive()
	{
	    return ($this->platforms->count() == 1);
	}
	
	public function isGettingOldToday()
	{
	    return ($this->release and $this->release->format('dm') == date('dm') and $this->release->year < date('Y'));
	}

	public function isNewRelease()
	{
		return ($this->release and $this->release->isPast() and $this->countdownByDays() <= config('site.trending_days_games'));
	}
	
	public function isUndated()
	{
		return (!$this->release or $this->release->timestamp < 0);
	}
	
	public function warnsToSend()
    {
        return $this->warns()->whereNull('sent');
    }
    
    public function warnsAlreadySent()
    {
        return $this->warns()->whereSent(1);
    }
}