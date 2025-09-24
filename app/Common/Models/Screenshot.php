<?php
namespace App\Common\Models;

use App\Common\Presenters\ScreenshotPresenter;

class Screenshot extends Base
{
	use ScreenshotPresenter;
	
	protected $table = 'screenshots';
    
    protected $fillable = [
    	'filename',
    ];
    
    protected $hidden = [];
    
    public function game()
    {
		return $this->belongsTo(Game::class, 'game_id');
	}
}
