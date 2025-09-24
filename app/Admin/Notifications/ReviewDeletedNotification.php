<?php
namespace App\Admin\Notifications;

use App\Admin\Mails\ReviewDeletedMail;

class ReviewDeletedNotification extends BaseNotification
{
	protected $text, $game;

    public function __construct($game)
    {
    	parent::__construct();
    	
    	$this->game = $game;
    	$this->text = 'Sua análise para <a href="https://notadogame.com/' . $game->slug . '">' . $game->name . '</a> foi removida por não atender nossas diretrizes';
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
        return (new ReviewDeletedMail($notifiable, $this->game, $this->text))->to($notifiable);
    }
}