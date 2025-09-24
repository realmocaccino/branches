<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\PlatformRequest;
use App\Admin\Models\Platform;
use App\Admin\Models\Generation;
use App\Admin\Models\Manufacturer;

class PlatformController extends BaseController
{
	protected $platform;
	protected $generations;
	protected $manufacturers;

	public function __construct(Platform $platform, Generation $generation, Manufacturer $manufacturer)
	{
		parent::__construct();
		
		$this->platform = $platform;
		$this->generations = $generation->orderBy('name')->pluck('name', 'id')->all();
		$this->manufacturers = $manufacturer->orderBy('name')->pluck('name', 'id')->all();
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Plataformas');
		
		$platforms = $this->platform->filter($relationship, $column, $value);
		
		return $this->view('platforms.index')->with([
			'platforms' => $platforms->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma plataforma encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Plataforma');
		
		return $this->view('platforms.create', [
			'generations' => $this->generations,
			'manufacturers' => $this->manufacturers
		]);
	}
	
	public function store(PlatformRequest $request)
	{
		$platform = $this->platform->create($request->all());
		
		if($request->logo) $platform->uploadFile('logo', $request->logo, 'png');
		
		return redirect(route('platforms.index'))->with('message', 'success|Plataforma criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Plataforma');
		
		return $this->view('platforms.edit', [
			'platform' => $this->platform->find($id),
			'generations' => $this->generations,
			'manufacturers' => $this->manufacturers
		]);
	}
	
	public function update(PlatformRequest $request, $id)
	{
		$platform = $this->platform->find($id);
		
		$platform->update($request->all());
		
		if($request->logo) {
			$platform->uploadFile('logo', $request->logo, 'png');
		} elseif($request->remove_logo) {
			$game->deleteFile('logo');
		}
		
		return redirect(route('platforms.index'))->with('message', 'success|Plataforma atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$platform = $this->platform->find($id);
	
		if($platform->logo) $platform->deleteFile('logo');
	
		$platform->delete();
		
		return response()->json([
			'message' => 'Plataforma excluída com sucesso!',
		]);
	}
}
