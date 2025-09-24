<?php
namespace App\Site\Jobs;

use App\Site\Models\{Game, User};
use App\Console\Actions\Game\FetchReleaseDate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class SearchForReleaseDateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $game;
    private $user;

    public function __construct(Game $game, User $user)
    {
        $this->game = $game;
        $this->user = $user;
    }

    public function handle(FetchReleaseDate $action)
    {
        try {
            $action->setGame($this->game)->crawl();

            if($action->getDate()) {
                $action->save();
                //$this->user->notify(new ReleaseDateFound($this->game));
            }
        } catch(ReleaseDateNotFoundException $exception) {
            //$this->user->notify(new ReleaseDateNotFound($this->game));
        }
    }
}