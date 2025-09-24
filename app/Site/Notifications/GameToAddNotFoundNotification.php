<?php
namespace App\Site\Notifications;

class GameToAddNotFoundNotification extends BaseNotification
{
    protected $text;

    public function __construct()
    {
    	parent::__construct();

    	$this->text = 'Infelizmente não conseguimos cadastrar o jogo solicitado.';
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