<?php
namespace App\Console\Notifications;

use App\Console\Mails\WarnMeMail;

class WarnMeNotification extends BaseNotification
{
	protected $game, $text;

    public function __construct($game)
    {
    	parent::__construct();
    	
    	$this->game = $game;
    	$this->text = '<a href="' . route('game.index', $game->slug) . '">' . $game->name . '</a> foi lançado hoje e já está disponível para avaliação';
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
        return (new WarnMeMail($notifiable, $this->game, $this->text))->to($notifiable);
    }
}
