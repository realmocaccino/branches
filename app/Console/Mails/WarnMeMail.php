<?php
namespace App\Console\Mails;

class WarnMeMail extends BaseMail
{
	public $user, $game, $text;

    public function __construct($user, $game, $text)
    {
    	parent::__construct();
    
    	$this->user = $user;
    	$this->game = $game;
    	$this->text = $text;
    }
    
    public function build()
    {
        return $this
        	->subject('Lançamento de ' . $this->game->name . ' - ' . $this->settings->name)
        	->view('console.mail.warn_me');
    }
}
