<?php
namespace App\Site\Notifications;

use App\Site\Mails\WelcomeMail;

class WelcomeNotification extends BaseNotification
{
    public function __construct()
    {
    	parent::__construct();
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }
     
    public function toDatabase($notifiable)
    {
        return ['text' => 'Seja bem vindo ao ' . $this->settings->name . ', ' . $notifiable->first_name . '!'];
    }

    public function toMail($notifiable)
    {
        return (new WelcomeMail($notifiable))->to($notifiable);
    }
}
