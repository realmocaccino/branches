<?php
namespace App\Site\Controllers\Traits;

use App\Site\Models\{Answer, Discussion};
use App\Site\Requests\Forum\{CreateDiscussionRequest, CreateAnswerRequest};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait ForumTrait
{
	public function forum()
	{
		$this->head->setTitle('Fórum' . (property_exists($this, 'game') ?  ' de ' . $this->game->name : null));
		$this->head->setDescription('Participe de discussões com a comunidade' . (property_exists($this, 'game') ? ' de ' . $this->game->name : ' do ' . $this->settings->name));
		
		$discussions = Discussion::when(property_exists($this, 'game'), function($query) {
			return $query->whereGameId($this->game->id);
		})->latest()->paginate(10);
		
		return $this->view('forum.index', [
			'discussions' => $discussions
		]);
	}
	
	public function discussion(Request $request)
	{
		$discussion = Discussion::whereId($request->discussionId)->firstOrFail();
		
		$this->head->setTitle($discussion->title . ' - ' . 'Fórum' . (property_exists($this, 'game') ?  ' de ' . $this->game->name : null));
		$this->head->setDescription('Participe de discussões com a comunidade' . (property_exists($this, 'game') ? ' de ' . $this->game->name : ' do ' . $this->settings->name));
		
		$answers = Answer::whereDiscussionId($discussion->id)->paginate(10);
		
		return $this->view('forum.discussion', [
			'discussion' => $discussion,
			'answers' => $answers
		]);
	}
	
	public function createDiscussionPage()
	{
		$this->head->setTitle('Criar discussão - Fórum' . (property_exists($this, 'game') ?  ' de ' . $this->game->name : null));
		$this->head->setDescription('Participe de discussões com a comunidade' . (property_exists($this, 'game') ? ' de ' . $this->game->name : ' do ' . $this->settings->name));
		
		$totalDiscussions = Discussion::when(property_exists($this, 'game'), function($query) {
			return $query->whereGameId($this->game->id);
		})->count();
		
		return $this->view('forum.create', [
			'totalDiscussions' => $totalDiscussions
		]);
	}
	
	public function createDiscussion(CreateDiscussionRequest $request)
	{
		$discussion = new Discussion;
		$discussion->status = 1;
		$discussion->user_id = Auth::id();
		if(property_exists($this, 'game')) $discussion->game_id = $this->game->id;
		$discussion->title = $request->title;
		$discussion->text = $request->text;
		$discussion->save();
		
		if(property_exists($this, 'game')) {
			$redirect = redirect()->route('game.forum.discussion', [$this->game->slug, $discussion->id]);
		} else {
			$redirect = redirect()->route('forum.discussion', [$discussion->id]);
		}
		
		return $redirect->with('alert', 'success|Discussão criada com sucesso');
	}
	
	public function answerDiscussion(CreateAnswerRequest $request)
	{
		$answer = new Answer;
		$answer->status = 1;
		$answer->user_id = Auth::id();
		$answer->discussion_id = $request->discussionId;
		$answer->text = $request->text;
		$answer->save();
		
		if(property_exists($this, 'game')) {
			$redirect = redirect()->route('game.forum.discussion', [$this->game->slug, $answer->discussion->id]);
		} else {
			$redirect = redirect()->route('forum.discussion', [$answer->discussion->id]);
		}
		
		return $redirect->with('alert', 'success|Resposta enviada com sucesso');
	}
	
	public function deleteDiscussion(Request $request)
	{
		$discussion = Discussion::findOrFail($request->discussionId);
		
		if($discussion->user->id == Auth::id()) {
			$discussion->answers()->delete();
			$discussion->delete();
			
			if(property_exists($this, 'game')) {
				$redirect = redirect()->route('game.forum.index', [$this->game->slug]);
			} else {
				$redirect = redirect()->route('forum.index');
			}
			
			return $redirect->with('alert', 'success|Discussão excluída');
		}
		
		if(property_exists($this, 'game')) {
			$redirect = redirect()->route('game.forum.discussion', [$this->game->slug, $discussion->id]);
		} else {
			$redirect = redirect()->route('forum.discussion', [$discussion->id]);
		}
		
		return $redirect->with('alert', 'warning|Operação não permitida');
	}
	
	public function deleteAnswer(Request $request)
	{
		$answer = Answer::findOrFail($request->answerId);
		$discussion = $answer->discussion;
		
		if(property_exists($this, 'game')) {
			$redirect = redirect()->route('game.forum.discussion', [$this->game->slug, $discussion->id]);
		} else {
			$redirect = redirect()->route('forum.discussion', [$discussion->id]);
		}
		
		if($answer->user->id == Auth::id()) {
			$answer->delete();
			
			return $redirect->with('alert', 'success|Resposta excluída');
		}
		
		return $redirect->with('alert', 'warning|Operação não permitida');
	}
}