<?php
namespace App\Site\Notifications;

use App\Site\Mails\NewFollowerMail;

class NewFollowerNotification extends BaseNotification
{
	protected $follower, $text;

    public function __construct($follower)
    {
    	parent::__construct();
    
    	$this->follower = $follower;
    	$this->text = '<a href="' . route('user.index', [$follower->slug]) . '">' . $follower->name . '</a> te seguiu';
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
        return (new NewFollowerMail($notifiable, $this->text, $this->follower))->to($notifiable);
    }
}