<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\ContactRequest;
use App\Admin\Models\Contact;

class ContactController extends BaseController
{
	protected $contact;

	public function __construct(Contact $contact)
	{
		parent::__construct();
		
		$this->contact = $contact;
	}

	public function index()
	{
		$this->head->setTitle('Páginas de Contato');
		
		return $this->view('contacts.index')->with([
			'contacts' => $this->contact->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma página de contato encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Página de Contato');
		
		return $this->view('contacts.create');
	}
	
	public function store(ContactRequest $request)
	{
		$this->contact->create($request->all());
		
		return redirect(route('contacts.index'))->with('message', 'success|Página de contato criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Página de Contato');
		
		return $this->view('contacts.edit', [
			'contact' => $this->contact->find($id)
		]);
	}
	
	public function update(ContactRequest $request, $id)
	{
		$this->contact->find($id)->update($request->all());
		
		return redirect(route('contacts.index'))->with('message', 'success|Página de contato atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->contact->destroy($id);
		
		return response()->json([
			'message' => 'Página de contato excluída com sucesso!',
		]);
	}
}
