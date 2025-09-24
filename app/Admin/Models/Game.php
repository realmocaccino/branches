<?php
namespace App\Admin\Models;

use App\Common\Models\Game as BaseGame;
use App\Admin\Presenters\GamePresenter;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;

class Game extends BaseGame
{
	use FormAccessible, GamePresenter;
	
	protected $fillable = [
		'name',
		'alias',
		'description',
    	'release',
    	'trailer',
    	'classification_id',
    	'status',
    	'slug',
    	'affiliate_link',
    	'affiliate_iframe',
    	'is_early_access'
    ];
    
    protected $hidden = [];
    
    public function formReleaseAttribute($value)
    {
        return ($this->release and $this->release->timestamp > 0) ? Carbon::parse($value)->format('d/m/Y') : null;
    }
    
    public function characteristics()
	{
		return parent::characteristics();
	}

	public function classification()
	{
		return parent::classification();
	}
	
	public function contributions()
	{
		return parent::contributions();
	}
	
	public function criterias()
	{
		return parent::criterias();
	}
    
    public function developers()
    {
		return parent::developers();
	}
	
	public function franchises()
	{
		return parent::franchises();
	}
    
	public function genres()
	{
		return parent::genres();
	}
	
	public function modes()
	{
		return parent::modes();
	}
	
	public function platforms()
	{
		return parent::platforms();
	}
	
	public function publishers()
	{
		return parent::publishers();
	}
	
	public function ratings()
	{
		return parent::ratings();
	}
	
	public function reviews()
	{
		return parent::reviews();
	}
	
	public function scores()
	{
		return parent::scores();
	}
	
	public function themes()
	{
		return parent::themes();
	}
}
