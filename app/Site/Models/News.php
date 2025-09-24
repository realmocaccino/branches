<?php
namespace App\Site\Models;

use App\Common\Models\News as BaseNews;
use App\Site\Presenters\BasePresenter;

class News extends BaseNews
{
	use BasePresenter;
}
