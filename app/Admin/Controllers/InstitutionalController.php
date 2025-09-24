<?php
namespace App\Admin\Controllers;

use App\Site\Models\User;
use App\Admin\Models\Institutional;
use App\Admin\Requests\InstitutionalRequest;
use App\Admin\Notifications\TermsChangedNotification;

class InstitutionalController extends BaseController
{
	protected $institutional;

	public function __construct(Institutional $institutional)
	{
		parent::__construct();
		
		$this->institutional = $institutional;
	}

	public function index()
	{
		$this->head->setTitle('Páginas Institucionais');
		
		return $this->view('institutionals.index')->with([
			'institutionals' => $this->institutional->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma página institucional encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Página Institucional');
		
		return $this->view('institutionals.create');
	}
	
	public function store(InstitutionalRequest $request)
	{
		$this->institutional->create($request->all());
		
		return redirect(route('institutionals.index'))->with('message', 'success|Página institucional criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Página Institucional');
		
		return $this->view('institutionals.edit', [
			'institutional' => $this->institutional->find($id)
		]);
	}
	
	public function update(InstitutionalRequest $request, $id)
	{
		$oldText = $this->institutional->find($id)->text;
	
		$this->institutional->find($id)->update($request->all());
		
		if($request->slug == 'termos' and $request->text != $oldText) {
			foreach(User::all() as $user) {
				$user->notify(new TermsChangedNotification());
			}
		}
		
		return redirect(route('institutionals.index'))->with('message', 'success|Página institucional atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->institutional->destroy($id);
		
		return response()->json([
			'message' => 'Página institucional excluída com sucesso!',
		]);
	}
}
