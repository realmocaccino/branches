<?php
namespace App\Site\Notifications;

class GameAddedNotification extends BaseNotification
{
    protected $text;

    public function __construct($game)
    {
    	parent::__construct();

    	$this->text = '<a href="' . route('game.index', [$game->slug]) . '">' . $game->name . '</a> já está disponível';
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