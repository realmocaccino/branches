<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\DiscussionRequest;
use App\Admin\Models\Discussion;

class DiscussionController extends BaseController
{
	protected $discussion;

	public function __construct(Discussion $discussion)
	{
		parent::__construct();
		
		$this->discussion = $discussion;
	}

	public function index()
	{
		$this->head->setTitle('Discussões');
		
		return $this->view('discussions.index')->with([
			'discussions' => $this->discussion->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma discussão encontrada']
		]);
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Discussão');
		
		return $this->view('discussions.edit', [
			'discussion' => $this->discussion->find($id)
		]);
	}
	
	public function update(DiscussionRequest $request, $id)
	{
		$this->discussion->find($id)->update($request->all());
		
		return redirect(route('discussions.index'))->with('message', 'success|Discussão atualizada com sucesso');
	}
	
	public function destroy($id)
	{
	    $discussion = $this->discussion->findOrFail($id);
	
	    $discussion->answers()->delete();
		$discussion->delete();
		
		return response()->json([
			'message' => 'Discussão excluída com sucesso!',
		]);
	}
}