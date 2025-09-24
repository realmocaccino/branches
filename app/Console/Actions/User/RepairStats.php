<?php
namespace App\Console\Actions\User;

use App\Site\Models\User;

class RepairStats
{
	protected $user;
	
    public function __construct($userSlug) {
    	$this->user = User::findBySlugOrFail($userSlug);
    }
    
    public function repair()
    {
        $this->repairTotalizers();
    }
    
    public function repairTotalizers()
    {
    	$this->user->total_ratings = $this->user->ratings->count();
    	$this->user->total_reviews = $this->user->reviews->count();
    	$this->user->total_contributions = $this->user->contributions->count();
		$this->user->save();
    }
}