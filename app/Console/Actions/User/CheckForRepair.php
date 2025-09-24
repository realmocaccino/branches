<?php
namespace App\Console\Actions\User;

use App\Site\Models\User;

class CheckForRepair
{
	protected $users;
	
	public function __construct() {
    	$this->users = User::all();
    }
    
    public function check()
    {
    	foreach($this->users as $user) {
    		$totalVerifiedRatings = $user->ratings()->whereHas('game')->count();
    		
    		if($user->total_ratings != $totalVerifiedRatings) {
    			(new RepairStats($user->slug))->repair();
    		}
    	}
    }
}
