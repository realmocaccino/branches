<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\MenuRequest;
use App\Admin\Models\Menu;

class MenuController extends BaseController
{
	protected $menu;

	public function __construct(Menu $menu)
	{
		parent::__construct();
		
		$this->menu = $menu;
	}

	public function index()
	{
		$this->head->setTitle('Menus');
		
		return $this->view('menus.index')->with([
			'menus' => $this->menu->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum menu encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Menu');
		
		return $this->view('menus.create');
	}
	
	public function store(MenuRequest $request)
	{
		$this->menu->create($request->all());
		
		return redirect(route('menus.index'))->with('message', 'success|Menu criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Menu');
		
		return $this->view('menus.edit', [
			'menu' => $this->menu->find($id)
		]);
	}
	
	public function update(MenuRequest $request, $id)
	{
		$this->menu->find($id)->update($request->all());
		
		return redirect(route('menus.index'))->with('message', 'success|Menu atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->menu->destroy($id);
		
		return response()->json([
			'message' => 'Menu excluído com sucesso!',
		]);
	}
}
