<?php
namespace App\Admin\Controllers;

use App\Site\Models\User;
use App\Admin\Requests\ReviewRequest;
use App\Admin\Models\Review;
use App\Admin\Notifications\ReviewDeletedNotification;
use App\Common\Helpers\ReviewHelper;

class ReviewController extends BaseController
{
	protected $review;

	public function __construct(Review $review)
	{
		parent::__construct();
		
		$this->review = $review;
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Análises');
		
		$reviews = $this->review->filter($relationship, $column, $value);
		
		return $this->view('reviews.index')->with([
			'reviews' => $reviews->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma análise encontrada']
		]);
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Análise');
		
		return $this->view('reviews.edit', [
			'review' => $this->review->find($id)
		]);
	}
	
	public function update(ReviewRequest $request, $id)
	{
		$this->review->find($id)->update($request->all());
		
		return redirect(route('reviews.index'))->with('message', 'success|Análise atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$review = $this->review->find($id);
		
		$user = User::find($review->user->id);
		$user->notify(new ReviewDeletedNotification($review->game));
		
		$reviewHelper = new ReviewHelper($review->rating);
		$reviewHelper->delete();
		
		return response()->json([
			'message' => 'Análise excluída com sucesso!',
		]);
	}
}