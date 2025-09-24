<?php
namespace App\Console\Commands;

use App\Site\Models\User;
use App\Console\Mails\Loose\DiscordMail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LooseMailCommand extends Command
{
    protected $signature = 'mail:loose';

    protected $description = 'Send a loose mail';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::subscribed()->get();

        foreach($users as $user) {
            Mail::to($user)->send(new DiscordMail($user));

            sleep(1);
        }
    }
}