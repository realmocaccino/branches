<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\NewsRequest;
use App\Admin\Models\News;

class NewsController extends BaseController
{
	protected $news;

	public function __construct(News $news)
	{
		parent::__construct();
		
		$this->news = $news;
	}

	public function index()
	{
		$this->head->setTitle('Novidades');
		
		return $this->view('news.index')->with([
			'news' => $this->news->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma novidade encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Novidade');
		
		return $this->view('news.create');
	}
	
	public function store(NewsRequest $request)
	{
		$this->news->create($request->all());
		
		return redirect(route('news.index'))->with('message', 'success|Novidade criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Novidade');
		
		return $this->view('news.edit', [
			'new' => $this->news->find($id)
		]);
	}
	
	public function update(NewsRequest $request, $id)
	{
		$this->news->find($id)->update($request->all());
		
		return redirect(route('news.index'))->with('message', 'success|Novidade atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->news->destroy($id);
		
		return response()->json([
			'message' => 'Novidade excluída com sucesso!',
		]);
	}
}
