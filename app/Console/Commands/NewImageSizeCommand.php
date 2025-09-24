<?php
namespace App\Console\Commands;

use App\Console\Actions\Misc\NewImageSize;

use Illuminate\Console\Command;

class NewImageSizeCommand extends Command
{
    protected $signature = 'site:newImageSize {basePath} {mirrorFolder} {newDimension} {quality?}';

    protected $description = 'Create a new image size from an existent greater one';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = new NewImageSize($this->argument('basePath'), $this->argument('mirrorFolder'), $this->argument('newDimension'), $this->argument('quality'));
        
        $action->create();
    }
}