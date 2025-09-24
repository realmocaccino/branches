<?php
namespace App\Site\Models;

use App\Common\Models\Collection as BaseCollection;
use App\Site\Presenters\BasePresenter;

class Collection extends BaseCollection
{
	use BasePresenter;
	
	protected $fillable = [
    	'user_id',
    	'name',
    	'slug',
    	'private'
    ];
    
    protected $hidden = [];

    public function getNameAttribute($value)
    {
        switch($this->slug) {
            case 'favorites':
                $name = trans('collections/index.favorites');
                break;
            case 'playing':
                $name = trans('collections/index.playing');
                break;
            case 'wishlist':
                $name = trans('collections/index.wishlist');
                break;
            default:
                $name = $value;
                break;
        }

        return $name;
    }

    public function isCustom()
    {
        return !$this->isDefault();
    }

    public function isDefault()
    {
        return in_array($this->slug, config('site.default_collections') ?? []);
    }

    public function isFavorites()
    {
        return $this->slug == 'favorites';
    }

    public function isPrivate()
    {
        return $this->private;
    }

    public function isPublic()
    {
        return !$this->private;
    }

    public function isWishlist()
    {
        return $this->slug == 'wishlist';
    }
	
	public function games()
	{
		return parent::games()->orderByRaw('LENGTH(`order`)')->orderBy('order');
	}
	
	public function user()
	{
		return parent::user();
	}
}