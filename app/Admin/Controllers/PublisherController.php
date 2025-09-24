<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\PublisherRequest;
use App\Admin\Models\Publisher;

class PublisherController extends BaseController
{
	protected $publisher;

	public function __construct(Publisher $publisher)
	{
		parent::__construct();
		
		$this->publisher = $publisher;
	}

	public function index()
	{
		$this->head->setTitle('Publicadoras');
		
		return $this->view('publishers.index')->with([
			'publishers' => $this->publisher->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma publicadora encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Publicadora');
		
		return $this->view('publishers.create');
	}
	
	public function store(PublisherRequest $request)
	{
		$this->publisher->create($request->all());
		
		return redirect(route('publishers.index'))->with('message', 'success|Publicadora criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Publicadora');
		
		return $this->view('publishers.edit', [
			'publisher' => $this->publisher->find($id)
		]);
	}
	
	public function update(PublisherRequest $request, $id)
	{
		$this->publisher->find($id)->update($request->all());
		
		return redirect(route('publishers.index'))->with('message', 'success|Publicadora atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->publisher->destroy($id);
		
		return response()->json([
			'message' => 'Publicadora excluída com sucesso!',
		]);
	}
}
