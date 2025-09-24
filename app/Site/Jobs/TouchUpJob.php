<?php
namespace App\Site\Jobs;

use App\Site\Models\Game;
use App\Console\Actions\Game\TouchUp;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class TouchUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function handle(TouchUp $action)
    {
        $action->handle($this->game);
    }
}