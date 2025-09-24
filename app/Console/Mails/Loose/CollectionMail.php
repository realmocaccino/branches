<?php
namespace App\Console\Mails\Loose;

use App\Console\Mails\BaseMail;

class CollectionMail extends BaseMail
{
	public $user, $games;

    public function __construct($user)
    {
    	parent::__construct();
    
    	$this->user = $user;
    }
    
    public function build()
    {
        return $this
        	->subject('Crie sua coleção de jogos - ' . $this->settings->name)
        	->view('console.mail.loose.collection');
    }
}