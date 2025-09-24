<?php
namespace App\Site\Models;

use App\Common\Models\Contact as BaseContact;
use App\Site\Presenters\BasePresenter;
use App\Site\Models\Traits\LocalizableTrait;

class Contact extends BaseContact
{
	use BasePresenter, LocalizableTrait;
}