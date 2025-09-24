<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\SettingsRequest;

class SettingsController extends BaseController
{
	public function edit()
	{
		$this->head->setTitle('Configurações');
		
		return $this->view('settings.edit');
	}
	
	public function update(SettingsRequest $request)
	{
		$this->settings->update($request->all());
		
		return redirect(route('settings.edit'))->with('message', 'success|Configurações atualizadas com sucesso');
	}
}
