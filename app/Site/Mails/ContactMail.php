<?php
namespace App\Site\Mails;

use Log;

class ContactMail extends BaseMail
{
	protected $contact;
	protected $request;
	
    public function __construct($contact, $request)
    {
    	parent::__construct();
    	
    	$this->contact = $contact;
    	$this->request = $request->all();
    }

    public function build()
    {
        return $this
        	->subject($this->contact->title . ' - ' . $this->settings->name)
        	->view('site.mails.contact', [
        		'contact' => $this->contact,
        		'request' => $this->request
        	]);
    }
}