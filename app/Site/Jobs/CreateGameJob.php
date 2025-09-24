<?php
namespace App\Site\Jobs;

use App\Site\Notifications\{GameAddedNotification, GameAlreadyExistsNotification, GameToAddNotFoundNotification};
use App\Common\Exceptions\GameAlreadyExistsException;
use App\Console\Exceptions\{NoApiGameFoundException, NoApiGameSetException};
use App\Console\Actions\Game\FetchGame;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class CreateGameJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const GIANT_BOMB_VENDOR_TERM = 'giant-bomb';
    public const IGDB_VENDOR_TERM = 'igdb';
    public const STEAM_VENDOR_TERM = 'steam';
    
    public $tries = 1;

    private $vendor;
    private $apiGameId;
    private $user;

    public function __construct($vendor, $apiGameId, $user)
    {
        $this->vendor = $vendor;
        $this->apiGameId = $apiGameId;
        $this->user = $user;
    }

    public function handle(FetchGame $action)
    {
        try {
            switch($this->vendor) {
                case(self::GIANT_BOMB_VENDOR_TERM):
                    $action->setGiantBombGame($this->apiGameId)->guessIgdbGame()->guessSteamGame();
                break;
                case(self::IGDB_VENDOR_TERM):
                    $action->setIgdbGame($this->apiGameId)->guessGiantBombGame()->guessSteamGame();
                break;
                case(self::STEAM_VENDOR_TERM):
                    $action->setSteamGame($this->apiGameId)->guessGiantBombGame()->guessIgdbGame();
                break;
            }

            $action->setUserWhoContributed($this->user)->create()->setAdditionalData();
            
            $this->user->notify(new GameAddedNotification($action->game));
        } catch(GameAlreadyExistsException $exception) {
            $this->user->notify(new GameAlreadyExistsNotification());
        } catch(NoApiGameSetException $exception) {
            $this->user->notify(new GameToAddNotFoundNotification());
        } catch(NoApiGameFoundException $exception) {}
    }
}