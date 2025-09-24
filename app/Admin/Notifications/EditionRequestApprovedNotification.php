<?php
namespace App\Admin\Notifications;

use App\Admin\Mails\EditionRequestApprovedMail;

class EditionRequestApprovedNotification extends BaseNotification
{
	protected $text;

    public function __construct($entityName)
    {
    	parent::__construct();
    	
    	$this->text = 'Sua edição para ' . $entityName . ' foi aprovada';
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }
     
    public function toDatabase($notifiable)
    {
        return ['text' => $this->text];
    }

    public function toMail($notifiable)
    {
        return (new EditionRequestApprovedMail($notifiable, $this->text))->to($notifiable);
    }
}
