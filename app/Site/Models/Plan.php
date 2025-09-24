<?php
namespace App\Site\Models;

use App\Common\Models\Plan as BasePlan;
use App\Site\Presenters\BasePresenter;

class Plan extends BasePlan
{
	use BasePresenter;

    public function getValidityAttribute()
    {
        return now()->addDays($this->days);
    }

    public function priceInBRL()
    {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    public function priceInCents()
    {
        return str_replace('.', '', $this->price);
    }
}