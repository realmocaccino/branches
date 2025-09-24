<?php
namespace App\Common\Models;

use App\Common\Presenters\SettingsPresenter;

class Settings extends Base
{
    protected $table = 'settings';
    
    use SettingsPresenter;
}
