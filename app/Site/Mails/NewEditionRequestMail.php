<?php
namespace App\Site\Mails;

class NewEditionRequestMail extends BaseMail
{
	protected $modelName;
	protected $entityName;
	protected $user;

    public function __construct($modelName, $entityName, $user)
    {
    	parent::__construct();
    	
    	$this->modelName = $modelName;
    	$this->entityName = $entityName;
    	$this->user = $user;
    }

    public function build()
    {
        return $this
        	->subject('Nova Solicitação de Edição - ' . $this->settings->name)
        	->view('site.mails.new_edition_request', [
        		'modelName' => $this->modelName,
    			'entityName' => $this->entityName,
        		'user' => $this->user
        	]);
    }
}