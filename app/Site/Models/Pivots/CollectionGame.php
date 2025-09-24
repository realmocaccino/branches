<?php
namespace App\Site\Models\Pivots;

use App\Site\Models\{Collection, Game, User};

use Illuminate\Database\Eloquent\Relations\Pivot;
use Znck\Eloquent\Traits\BelongsToThrough;

class CollectionGame extends Pivot
{
    use BelongsToThrough;

    protected $table = 'collection_game';

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }
    
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function user()
    {
        return $this->belongsToThrough(User::class, Collection::class);
    }
}