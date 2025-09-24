<?php
namespace App\Console\Actions\Misc;

use App\Console\Actions\User\RepairStats;
use App\Site\Helpers\Site;
use App\Site\Models\{Contribution, User};

class CustomRoutines
{
    public function handle()
    {
        $this->transferGustavoContributionsToOfficialUser();
    }

    private function transferGustavoContributionsToOfficialUser()
    {
        $gustavoUser = User::findOrFail(1);
        $officialUser = Site::getOfficialUser();

        Contribution::where('user_id', $gustavoUser->id)->update(['user_id' => $officialUser->id]);

        (new RepairStats($gustavoUser->slug))->repair();
        (new RepairStats($officialUser->slug))->repair();
    }
}