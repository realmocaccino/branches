<?php
namespace App\Site\Models;

use App\Common\Models\Institutional as BaseInstitutional;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Institutional extends BaseInstitutional
{
	use BasePresenter, LocalizableTrait;
}