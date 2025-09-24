<?php
namespace App\Admin\Notifications;

use App\Admin\Mails\TermsChangedMail;

class TermsChangedNotification extends BaseNotification
{
	protected $text;

    public function __construct()
    {
    	parent::__construct();
    	
    	$this->text = 'Nossos <a href="https://notadogame.com/termos">termos de uso</a> foram atualizados';
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
        return (new TermsChangedMail($notifiable, $this->text))->to($notifiable);
    }
}
