<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\ModeRequest;
use App\Admin\Models\Mode;

class ModeController extends BaseController
{
	protected $mode;

	public function __construct(Mode $mode)
	{
		parent::__construct();
		
		$this->mode = $mode;
	}

	public function index()
	{
		$this->head->setTitle('Modos de Jogo');
		
		return $this->view('modes.index')->with([
			'modes' => $this->mode->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum modo de jogo encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Modo de Jogo');
		
		return $this->view('modes.create');
	}
	
	public function store(ModeRequest $request)
	{
		$this->mode->create($request->all());
		
		return redirect(route('modes.index'))->with('message', 'success|Modo de jogo criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Modo de Jogo');
		
		return $this->view('modes.edit', [
			'mode' => $this->mode->find($id)
		]);
	}
	
	public function update(ModeRequest $request, $id)
	{
		$this->mode->find($id)->update($request->all());
		
		return redirect(route('modes.index'))->with('message', 'success|Modo de jogo atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->mode->destroy($id);
		
		return response()->json([
			'message' => 'Modo de jogo excluído com sucesso!',
		]);
	}
}
