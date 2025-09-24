<?php
namespace App\Common\Models;

use Znck\Eloquent\Traits\BelongsToThrough;

class Answer extends Base
{
	use BelongsToThrough;

    protected $table = 'answers';
    
    public function game()
	{
		return $this->belongsToThrough(Game::class, Discussion::class);
	}
	
	public function discussion()
	{
		return $this->belongsTo(Discussion::class, 'discussion_id');
	}
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}