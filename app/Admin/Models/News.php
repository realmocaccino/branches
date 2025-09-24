<?php
namespace App\Admin\Models;

use App\Common\Models\News as BaseNews;
use App\Admin\Presenters\BasePresenter;

class News extends BaseNews
{
    use BasePresenter;
    
    protected $fillable = [
    	'title',
    	'text',
    	'status',
    	'slug',
    ];
    
    protected $hidden = [];
}
