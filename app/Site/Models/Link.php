<?php
namespace App\Site\Models;

use App\Common\Models\Link as BaseLink;
use App\Site\Presenters\LinkPresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Link extends BaseLink
{
	use LinkPresenter, LocalizableTrait;
}