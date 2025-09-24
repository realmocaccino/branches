<?php
namespace App\Site\Mails;

class NewReviewLikeMail extends BaseMail
{
	public $user, $text;

    public function __construct($user, $text)
    {
    	parent::__construct();
    	
    	$this->user = $user;
    	$this->text = $text;
    }

    public function build()
    {
        return $this
        	->subject('Nova curtida em sua análise - ' . $this->settings->name)
        	->view('site.mails.new_review_like');
    }
}