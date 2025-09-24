<?php
namespace App\Admin\Mails;

class EditionRequestApprovedMail extends BaseMail
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
        	->subject('Edição aprovada - ' . $this->settings->name)
        	->view('admin.mails.edition_request_approved');
    }
}
