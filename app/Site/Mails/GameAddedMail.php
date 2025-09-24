<?php
namespace App\Site\Mails;

class GameAddedMail extends BaseMail
{
	protected $game;
	protected $user;

    public function __construct($game, $user)
    {
    	parent::__construct();
    	
    	$this->game = $game;
    	$this->user = $user;
    }

    public function build()
    {
        return $this
        	->subject('Novo Jogo Cadastrado - ' . $this->settings->name)
        	->view('site.mails.game_added', [
        		'game' => $this->game,
        		'user' => $this->user
        	]);
    }
}