<?php
namespace App\Admin\Models;

use App\Common\Models\Settings as BaseSettings;

class Settings extends BaseSettings
{
    protected $fillable = [
    	'url',
    	'name',
    	'description_pt',
    	'description_en',
    	'description_es',
    	'description_fr',
    	'email',
    	'analytics',
    	'robots',
    	'advertisements',
    ];
    
    protected $hidden = [];
}
