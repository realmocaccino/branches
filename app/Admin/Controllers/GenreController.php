<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\GenreRequest;
use App\Admin\Models\Genre;

class GenreController extends BaseController
{
	protected $genre;

	public function __construct(Genre $genre)
	{
		parent::__construct();
		
		$this->genre = $genre;
	}

	public function index()
	{
		$this->head->setTitle('Gêneros');
		
		return $this->view('genres.index')->with([
			'genres' => $this->genre->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum gênero encontrado']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Gênero');
		
		return $this->view('genres.create');
	}
	
	public function store(GenreRequest $request)
	{
		$this->genre->create($request->all());
		
		return redirect(route('genres.index'))->with('message', 'success|Gênero criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Gênero');
		
		return $this->view('genres.edit', [
			'genre' => $this->genre->find($id)
		]);
	}
	
	public function update(GenreRequest $request, $id)
	{
		$this->genre->find($id)->update($request->all());
		
		return redirect(route('genres.index'))->with('message', 'success|Gênero atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->genre->destroy($id);
		
		return response()->json([
			'message' => 'Gênero excluído com sucesso!',
		]);
	}
}
