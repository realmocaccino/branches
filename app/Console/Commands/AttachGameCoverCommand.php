<?php
namespace App\Console\Commands;

use App\Console\Actions\Game\AttachCover;

use Illuminate\Console\Command;

class AttachGameCoverCommand extends Command
{
    protected $signature = 'game:attachCover {gameSlug}';

    protected $description = 'Attach a game cover image from a URL';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new AttachCover($this->argument('gameSlug'));
        
        if($action->game->cover and !$this->confirm($action->game->name . ' já possui uma capa. Deseja renovar?')) exit();
        
        $action->attach($this->ask('Insira a URL da imagem e pressione ENTER'));
    }
}
