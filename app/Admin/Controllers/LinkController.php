<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\LinkRequest;
use App\Admin\Models\Link;
use App\Admin\Models\Menu;

class LinkController extends BaseController
{
	protected $link;
	protected $menus;
	protected $targets;

	public function __construct(Link $link, Menu $menu)
	{
		parent::__construct();
		$this->link = $link;
		$this->menus = $menu->orderBy('name')->pluck('name', 'id')->all();
		$this->targets = [
			'_self' => 'Mesma Janela',
			'_blank' => 'Nova Janela'
		];
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Links');
		
		$links = $this->link->filter($relationship, $column, $value);
		
		return $this->view('links.index')->with([
			'links' => $links->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum link encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Link');
		
		return $this->view('links.create', [
			'menus' => $this->menus,
			'targets' => $this->targets
		]);
	}
	
	public function store(LinkRequest $request)
	{
		$this->link->create($request->all());
		
		return redirect(route('links.index'))->with('message', 'success|Link criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Link');
		
		return $this->view('links.edit', [
			'link' => $this->link->find($id),
			'menus' => $this->menus,
			'targets' => $this->targets
		]);
	}
	
	public function update(LinkRequest $request, $id)
	{
		$this->link->find($id)->update($request->all());
		
		return redirect(route('links.index'))->with('message', 'success|Link atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->link->destroy($id);
		
		return response()->json([
			'message' => 'Link excluído com sucesso!',
		]);
	}
}
