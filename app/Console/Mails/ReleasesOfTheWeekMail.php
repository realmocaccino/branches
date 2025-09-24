<?php
namespace App\Console\Mails;

class ReleasesOfTheWeekMail extends BaseMail
{
	public $games;
	public $user;

    public function __construct($games, $user)
    {
    	parent::__construct();
    
    	$this->games = $games->sortBy('release')->all();
    	$this->user = $user;
    }
    
    public function build()
    {
        return $this
        	->subject('Lançamentos da Semana - ' . $this->settings->name)
        	->view('console.mail.releases_of_the_week');
    }
}