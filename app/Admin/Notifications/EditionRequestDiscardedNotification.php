<?php
namespace App\Admin\Notifications;

class EditionRequestDiscardedNotification extends BaseNotification
{
	protected $text;

    public function __construct($entityName)
    {
    	parent::__construct();
    	
    	$this->text = 'Infelizmente sua edição para ' . $entityName . ' não foi aprovada';
    }

    public function via($notifiable)
    {
        return ['database'];
    }
     
    public function toDatabase($notifiable)
    {
        return ['text' => $this->text];
    }
}
