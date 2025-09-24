<?php
namespace App\Admin\Presenters;

trait GamePresenter
{
	use BasePresenter;
	
	public function syncRelationships($data, $noVerification = true)
	{
		if($noVerification or isset($data->characteristics)) $this->characteristics()->sync($data->characteristics);
		if($noVerification or isset($data->criterias)) $this->criterias()->sync($data->criterias);
		if($noVerification or isset($data->developers)) $this->developers()->sync($data->developers);
		if($noVerification or isset($data->franchises)) $this->franchises()->sync($data->franchises);
		if($noVerification or isset($data->genres)) $this->genres()->sync($data->genres);
		if($noVerification or isset($data->modes)) $this->modes()->sync($data->modes);
		if($noVerification or isset($data->platforms)) $this->platforms()->sync($data->platforms);
		if($noVerification or isset($data->publishers)) $this->publishers()->sync($data->publishers);
		if($noVerification or isset($data->themes)) $this->themes()->sync($data->themes);
	}
}
