<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\AdvertiserRequest;
use App\Admin\Models\Advertiser;

class AdvertiserController extends BaseController
{
	protected $advertiser;

	public function __construct(Advertiser $advertiser)
	{
		parent::__construct();
		
		$this->advertiser = $advertiser;
	}

	public function index()
	{
		$this->head->setTitle('Anunciantes');
		
		return $this->view('advertisers.index')->with([
			'advertisers' => $this->advertiser->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum anunciante encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Anunciante');
		
		return $this->view('advertisers.create');
	}
	
	public function store(AdvertiserRequest $request)
	{
		$this->advertiser->create($request->all());
		
		return redirect(route('advertisers.index'))->with('message', 'success|Anunciante criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Anunciante');
		
		return $this->view('advertisers.edit', [
			'advertiser' => $this->advertiser->find($id)
		]);
	}
	
	public function update(AdvertiserRequest $request, $id)
	{
		$this->advertiser->find($id)->update($request->all());
		
		return redirect(route('advertisers.index'))->with('message', 'success|Anunciante atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->advertiser->destroy($id);
		
		return response()->json([
			'message' => 'Anunciante excluído com sucesso!',
		]);
	}
}
