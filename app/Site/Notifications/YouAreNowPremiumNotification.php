<?php
namespace App\Site\Notifications;

use App\Site\Mails\YouAreNowPremiumMail;

class YouAreNowPremiumNotification extends BaseNotification
{
	protected $text;

    public function __construct()
    {
    	parent::__construct();

    	$this->text = 'Você agora é um usuário <a href="' . route('premium.index') . '"><strong>Premium</strong></a>';
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
        return (new YouAreNowPremiumMail($notifiable, $this->text))->to($notifiable);
    }
}