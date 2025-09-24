<?php
namespace App\Admin\Mails;

class TermsChangedMail extends BaseMail
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
        	->subject('Termos de uso atualizados - ' . $this->settings->name)
        	->view('admin.mails.terms_changed');
    }
}
