<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\ThemeRequest;
use App\Admin\Models\Theme;

class ThemeController extends BaseController
{
	protected $theme;

	public function __construct(Theme $theme)
	{
		parent::__construct();
		
		$this->theme = $theme;
	}

	public function index()
	{
		$this->head->setTitle('Temas');
		
		return $this->view('themes.index')->with([
			'themes' => $this->theme->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum tema encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Tema');
		
		return $this->view('themes.create');
	}
	
	public function store(ThemeRequest $request)
	{
		$this->theme->create($request->all());
		
		return redirect(route('themes.index'))->with('message', 'success|Tema criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Tema');
		
		return $this->view('themes.edit', [
			'theme' => $this->theme->find($id)
		]);
	}
	
	public function update(ThemeRequest $request, $id)
	{
		$this->theme->find($id)->update($request->all());
		
		return redirect(route('themes.index'))->with('message', 'success|Tema atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->theme->destroy($id);
		
		return response()->json([
			'message' => 'Tema excluído com sucesso!',
		]);
	}
}
