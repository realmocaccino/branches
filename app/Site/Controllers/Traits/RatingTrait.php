<?php
namespace App\Site\Controllers\Traits;

use App\Site\Models\Game;
use App\Site\Requests\RatingRequest;
use App\Site\Helpers\Chart;
use App\Common\Helpers\{RatingHelper, ScoreHelper};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Route};

trait RatingTrait
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
			$this->rating = $this->game->ratings()->whereUserId($this->user->id)->first();
			
			return $next($request);
		});
	}

	public function index()
	{
		if(property_exists($this, 'head')) $this->head->setTitle(trans('components/rating/index.title') . $this->game->name);
		
		$criterias = $this->game->criterias()->where('criterias.status', 1);
		$chartLabels = $criterias->orderBy('criterias.order')->pluck('name' . config('site.locale_column_suffix'));
		if($this->rating) {
			$chartDatasets[] = [
				'label' => '',
				'data' => $this->rating->scores->pluck('value'),
				'score' => $this->rating->score
			];
		} else {
			$chartDatasets[] = [
				'label' => '',
				'data' => array_fill(0, $criterias->count(), ScoreHelper::DEFAULT_SCORE),
				'score' => ScoreHelper::DEFAULT_SCORE
			];
		}
		
		return $this->view('rating.index', [
			'defaultScore' => ScoreHelper::DEFAULT_SCORE,
			'maximumScore' => ScoreHelper::MAXIMUM_SCORE,
			'minimumScore' => ScoreHelper::MINIMUM_SCORE,
			'scoreInterval' => ScoreHelper::SCORE_INTERVAL,
			'game' => $this->game,
			'user' => $this->user,
			'rating' => $this->rating,
			'chartLabels' => $chartLabels,
			'chartDatasets' => $chartDatasets
		]);
	}
	
	public function save(RatingRequest $request)
	{
		$ratingHelper = new RatingHelper($this->game, $this->user, $this->rating);

		if(!$ratingHelper->isInadequateRating($request)) {
		    $rating = $ratingHelper->save($request);
		    $message = 'Avaliação ' . ($ratingHelper->isNew() ? 'criada' : 'atualizada') . ' com sucesso';
		    
		    if($this->request->ajax()) {
			    $response = [
				    'message' => $message,
				    'isNew' => $ratingHelper->isNew(),
				    'ratingId' => $rating->id,
				    'ratingItem' => view('site.components.item.rating', ['rating' => $rating, 'cover' => (in_array($request->origin_route, ['game.index', 'game.ratings']) ? 'user' : 'game')])->render()
			    ];
			    
			    if(strstr($request->origin_route, 'game.')) {
				    $response += [
					    'rateButton' => view('site.game.components.rateButton', [
						    'game' => $this->game,
						    'userRating' => $rating
					    ])->render(),
					    'scores' => view('site.game.components.scores', [
						    'game' => $this->game,
						    'userRating' => $rating
					    ])->render()
				    ];
			    }
			    
			    if($request->origin_route == 'game.index') {
				    $response += [
					    'criteriasChartDatasets' => Chart::prepareDatasets($this->game, $rating),
					    'criteriasScores' => view('site.game.components.index.criteriasScores', ['game' => $this->game, 'userRating' => $rating])->render(),
					    'platformsScores' => view('site.game.components.index.platformsScores', ['game' => $this->game])->render()
				    ];
			    }
		    
			    if(!$rating->review) {
				    $response += ['reviewWrite' => view('site.components.review.write', ['rating' => $rating])->render()];
			    } else {
				    $response += [
					    'reviewId' => $rating->review->id,
					    'reviewItem' => view('site.components.item.review', ['review' => $rating->review, 'cover' => ($request->origin_route == 'account.index' ? 'game' : 'user')])->render()
				    ];
			    }

			    return response()->json($response);
		    } else {
			    return redirect()->route('game.index', $this->game->slug)->with('alert', 'success|' . $message);
		    }
		 } else {
		    $message = 'Avalie com critério';
		 
		    if($this->request->ajax()) {
		        return response()->json([
		            'error' => true,
				    'message' => $message
			    ]);
		    } else {
			    return redirect()->route('rating.index', $this->game->slug)->with('alert', 'warning|' . $message);
		    }
		 }
	}
	
	public function deletePage()
	{
		if(!$this->rating) abort(404);
		
		if(property_exists($this, 'head')) {
			$this->head->setTitle(trans('components/rating/delete.title') . $this->game->name);
		}
	
		return $this->view('rating.delete', [
			'game' => $this->game,
			'user' => $this->user,
			'rating' => $this->rating
		]);
	}
	
	public function delete()
	{
		if(!$this->rating) abort(404);
		
		$ratingId = $this->rating->id;
		$reviewId = optional($this->rating->review)->id;
		
		$ratingHelper = new RatingHelper($this->game, $this->user, $this->rating);
		$ratingHelper->delete();
		
		$message = 'Avaliação excluída com sucesso';
		
		if($this->request->ajax()) {
			$response = [
				'message' => $message,
				'ratingId' => $ratingId
			];
			
			if(strstr($this->request->origin_route, 'game.')) {
				$response += [
					'rateButton' => view('site.game.components.rateButton', [
						'game' => $this->game
					])->render(),
					'scores' => view('site.game.components.scores', [
						'game' => $this->game
					])->render()
				];
			}
	
			if($this->request->origin_route == 'game.index' and $this->game->ratings()->count()) {
				$response += [
					'reviewDisabled' => view('site.components.review.disabled', ['game' => $this->game])->render(),
					'reviewId' => $reviewId,
					'criteriasChartDatasets' => Chart::prepareDatasets($this->game),
					'criteriasScores' => view('site.game.components.index.criteriasScores', ['game' => $this->game])->render(),
					'platformsScores' => view('site.game.components.index.platformsScores', ['game' => $this->game])->render()
				];
			}
			
			return response()->json($response);
		} else {
			if($this->request->origin_route == 'game.index') {
				$redirectRoute = redirect()->route('game.index', $this->game->slug);
			} else {
				$redirectRoute = redirect()->route('account.ratings');
			}
			
			return $redirectRoute->with('alert', 'success|' . $message);
		}
	}
}