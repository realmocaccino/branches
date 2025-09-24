<?php
namespace App\Site\Controllers;

use App\Site\Models\{Game, Review, ReviewFeedback, User};
use App\Site\Notifications\NewReviewLikeNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewFeedbackController extends BaseController
{
	public function fetch($reviewId)
	{
		return view('site.components.item.review_feedback', [
			'review' => Review::find($reviewId)
		]);
	}
	
	public function vote(Request $request)
	{
		$user = Auth::guard('site')->user();
		$userReview = User::findBySlugOrFail($request->userSlug);
		$game = Game::findBySlugOrFail($request->gameSlug);
		$review = $game->ratings()->whereUserId($userReview->id)->firstOrFail()->review;
		
		if($user->id == $userReview->id) {
			return response()->json([
				'error' => 'same_author',
				'message' => 'Você não pode votar em sua própria análise'
			]);
		}
		
		$reviewFeedback = ReviewFeedback::firstOrNew(['review_id' => $review->id, 'user_id' => $user->id]);
		
		if($reviewFeedback->feedback == $request->feedback) {
			$reviewFeedback->delete();
		
		    if($request->ajax()) {
			    return response()->json([
				    'success' => true,
				    'deleted' => true
			    ]);
			} else {
			    return redirect()->route('game.review', ['gameSlug' => $game->slug, 'userSlug' => $userReview->slug])->with('alert', 'success|Voto removido');
			}
		} else {
			$reviewFeedback->feedback = $request->feedback;
			$reviewFeedback->save();
			
			if($reviewFeedback->wasRecentlyCreated and $request->feedback) {
				$userReview->notify(new NewReviewLikeNotification($user, $game, $review));
			}
			
			if($request->ajax()) {
			    return response()->json([
				    'success' => true,
				    'wasRecentlyCreated' => $reviewFeedback->wasRecentlyCreated
			    ]);
			} else {
			    return redirect()->route('game.review', ['gameSlug' => $game->slug, 'userSlug' => $userReview->slug])->with('alert', 'success|Voto enviado');
			}
		}
	}
}