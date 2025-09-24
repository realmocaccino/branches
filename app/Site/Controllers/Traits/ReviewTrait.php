<?php
namespace App\Site\Controllers\Traits;

use App\Site\Models\Game;
use App\Site\Requests\ReviewRequest;
use App\Common\Helpers\ReviewHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait ReviewTrait
{
	protected $game;
	protected $user;
	protected $rating;
	protected $request;

	public function __construct(Request $request)
	{
		parent::__construct();
		
		$this->request = $request;
		$this->game = Game::findBySlugOrFail($this->request->gameSlug);
		
		$this->middleware(function($request, $next) {
			$this->user = Auth::guard('site')->user();
			$this->rating = $this->game->ratings()->whereUserId($this->user->id)->firstOrFail();
			
			return $next($request);
		});
	}
	
	public function save(ReviewRequest $request)
	{
		$reviewHelper = new ReviewHelper($this->rating);
		$review = $reviewHelper->save($request);
		
		if($this->request->ajax()) {
			return response()->json([
				'reviewItem' => view('site.components.item.review', [
					'review' => $review
				])->render()
			]);
		} else {
			return redirect()->back()->with('alert', 'success|Análise ' . ($reviewHelper->isNew() ? 'criada' : 'atualizada') . ' com sucesso');
		}
	}
	
	public function delete()
	{
		if(!$this->rating->review) abort(404);
		
		$reviewHelper = new ReviewHelper($this->rating);
		$reviewHelper->delete();
		
		if($this->request->ajax()) {
			return response()->json([
				'writeContainer' => view('site.components.review.write', [
					'rating' => $this->game->ratings()->whereUserId($this->user->id)->firstOrFail(),
				])->render()
			]);
		} else {
			return redirect()->back()->with('alert', 'success|Análise excluída com sucesso');
		}
	}
}