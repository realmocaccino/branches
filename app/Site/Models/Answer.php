<?php
namespace App\Site\Models;

use App\Common\Models\Answer as BaseAnswer;
use App\Site\Presenters\BasePresenter;

class Answer extends BaseAnswer
{
    use BasePresenter;
    
    public function game()
	{
		return parent::game()->where('games.status', 1);
	}
	
	public function discussion()
	{
		return parent::discussion()->where('discussions.status', 1);
	}
	
	public function user()
	{
		return parent::user()->where('users.status', 1);
	}
}
