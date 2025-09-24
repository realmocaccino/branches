<?php
namespace App\Site\Notifications;

use App\Site\Mails\NewReviewLikeMail;

class NewReviewLikeNotification extends BaseNotification
{
	protected $user, $game, $review, $text;

    public function __construct($user, $game, $review)
    {
    	parent::__construct();
    
    	$this->user = $user;
    	$this->game = $game;
    	$this->review = $review;
    	$this->text = '<a href="' . route('user.index', [$user->slug]) . '">' . $user->name . '</a> curtiu sua <a href="' . route('game.review', [$game->slug, $review->user->slug]) . '">análise</a> para ' . $game->name;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }
    
    public function toDatabase($notifiable)
    {
        return ['text' => $this->text];
    }

    public function toMail($notifiable)
    {
        return (new NewReviewLikeMail($notifiable, $this->text))->to($notifiable);
    }
}
