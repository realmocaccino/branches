<?php
namespace App\Site\Models;

use App\Common\Models\Score as BaseScore;
use App\Site\Presenters\BasePresenter;

class Score extends BaseScore
{
	use BasePresenter;
	
	public function criteria()
	{
		return $this->belongsTo(Criteria::class, 'criteria_id')->where('criterias.status', 1);
	}

    public function rating()
    {
		return parent::rating();
	}
}
