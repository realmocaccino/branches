<?php
namespace App\Site\Notifications;

class GameAlreadyExistsNotification extends BaseNotification
{
    protected $text;

    public function __construct()
    {
    	parent::__construct();

    	$this->text = 'O jogo solicitado já existe em nosso catálogo.';
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