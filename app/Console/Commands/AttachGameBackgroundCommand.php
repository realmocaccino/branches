<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\AttachBackground;

use Illuminate\Console\Command;

class AttachGameBackgroundCommand extends Command
{
    protected $signature = 'game:attachBackground {gameSlug}';

    protected $description = 'Attach a game background image from a URL';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new AttachBackground($this->argument('gameSlug'));
        
        if($action->game->background and !$this->confirm($action->game->name . ' já possui um fundo. Deseja renovar?')) exit();
        
        $action->attach($this->ask('Insira a URL da imagem e pressione ENTER'));
    }
}
