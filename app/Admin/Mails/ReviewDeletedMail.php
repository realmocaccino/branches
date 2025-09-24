<?php
namespace App\Admin\Mails;

class ReviewDeletedMail extends BaseMail
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
        	->subject('Análise removida - ' . $this->settings->name)
        	->view('admin.mails.review_deleted');
    }
}