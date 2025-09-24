<?php
namespace App\Admin\Models;

use App\Common\Models\Score as BaseScore;
use App\Admin\Presenters\BasePresenter;

class Score extends BaseScore
{
	use BasePresenter;
	
	protected $fillable = [];
    
    protected $hidden = [];

	public function criterias()
	{
		return parent::criterias();
	}

    public function ratings()
    {
		return parent::ratings();
	}
}
