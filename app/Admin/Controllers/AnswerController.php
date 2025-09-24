<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\AnswerRequest;
use App\Admin\Models\Answer;

class AnswerController extends BaseController
{
	protected $answer;

	public function __construct(Answer $answer)
	{
		parent::__construct();
		
		$this->answer = $answer;
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Respostas');
		
		$answers = $this->answer->filter($relationship, $column, $value);
		
		return $this->view('answers.index')->with([
			'answers' => $answers->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma resposta encontrada']
		]);
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Resposta');
		
		return $this->view('answers.edit', [
			'answer' => $this->answer->find($id)
		]);
	}
	
	public function update(AnswerRequest $request, $id)
	{
		$this->answer->find($id)->update($request->all());
		
		return redirect(route('answers.index'))->with('message', 'success|Resposta atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->answer->destroy($id);
		
		return response()->json([
			'message' => 'Resposta excluída com sucesso!',
		]);
	}
}