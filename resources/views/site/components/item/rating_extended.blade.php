<div class="item-rating-extended item-rating-{{ $rating->id }}">
    <div class="item-rating-extended-header">
		<div class="item-rating-extended-header-data descriptive">
		    @if(!isset($cover) or $cover == 'game')
			    @component('site.components.item.game_picture', [
				    'game' => $rating->game,
				    'size' => $coverSize ?? '78x90'
			    ])
			    @endcomponent
			    <a class="item-rating-extended-game-name @if(strlen($rating->game->name) > 26) name-too-long @endif" href="{{ route('game.index', ['gameSlug' => $rating->game->slug]) }}">{{ str_limit($rating->game->name, $nameLimit ?? 9999)  }}</a>
		    @elseif($cover == 'user')
			    @component('site.components.item.user_picture', [
				    'user' => $rating->user,
				    'size' => $coverSize ?? '48x60'
			    ])
			    @endcomponent
			    <a class="item-rating-extended-user-name @if(strlen($rating->user->name) > 26) name-too-long @endif" href="{{ route('user.index', ['userSlug' => $rating->user->slug]) }}">{{ str_limit($rating->user->name, $nameLimit ?? 9999)  }}</a>
		    @elseif($cover == 'game_user')
			    @component('site.components.item.user_picture', [
				    'user' => $rating->user,
				    'size' => '48x60'
			    ])
			    @endcomponent
			    <a class="item-rating-extended-user-name" href="{{ route('user.index', [$rating->user->slug]) }}">{{ $rating->user->name }}</a> @lang('components/item/rating.to') <a class="item-rating-extended-game-name" href="{{ route('game.index', [$rating->game->slug]) }}">{{ $rating->game->name }}</a>
				@component('site.components.item.game_picture', [
				    'game' => $rating->game,
				    'size' => '78x90'
			    ])
			    @endcomponent
		    @endif
		    <div class="item-rating-extended-header-data-bottom">
			    <div class="item-rating-extended-details">
				    @lang('components/item/rating.on')
				    <div class="item-rating-extended-platform">
					    @include('site.components.item.platform', [
						    'platform' => $rating->platform
					    ])
				    </div>
				    <span class="item-rating-extended-date">{{ $rating->updated_at->diffForHumans() }}</span>
			    </div>
			    <div class="item-rating-extended-actions">
			        @if($rating->review)
	                    <a class="item-rating-extended-actions-readReview" href="{{ route('game.review', [$rating->game->slug, $rating->user->slug]) }}"><span class="badge badge-big badge-primary">@lang('components/item/rating.read_review')</span></a>
	                @endif
			        @if(Auth::guard('site')->id() == $rating->user->id)
			            @if(!$rating->review)
	                        <a class="item-rating-extended-actions-writeReview" href="{{ route('game.reviews', $rating->game->slug) }}"><span class="badge badge-big badge-primary">@lang('components/item/rating.write_review')</span></a>
	                    @endif
				        <a class="dialog item-rating-extended-actions-change" href="{{ route('rating.index', $rating->game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $rating->game->slug) }}"><span class="badge badge-big badge-primary">@lang('components/item/rating.change')</span></a>
				        <a class="dialog item-rating-extended-actions-delete" href="{{ route('rating.delete', $rating->game->slug) }}" data-ajax-url="{{ route('rating.ajax.delete', $rating->game->slug) }}"><span class="badge badge-big badge-danger">@lang('components/item/rating.delete')</span></a>
			        @endif
	            </div>
		    </div>
        </div>
        <div class="item-rating-extended-header-score">
		    @component('site.components.item.score', [
			    'score' => $rating->score
		    ])
		    @endcomponent
	    </div>
	</div>
	@if($rating->review)
		@include('site.components.item.review', [
			'review' => $rating->review	
		])
	@endif
	<?php
		if(!isset($noChart) or !$noChart) {
		    $chartData = [
		        'labels' => $rating->game->criterias()->where('criterias.status', 1)->orderBy('criterias.order')->pluck('name' . config('site.locale_column_suffix')),
		        'datasets' => [
		            [
		                'label' => '',
		                'data' => $rating->scores->pluck('value'),
		                'score' => $rating->score
		            ]
		        ]
		    ];
	?>
		<hr>
		<div class="item-rating-extended-chart">
			<canvas id="item-rating-extended-{{ $rating->id }}-criteriasChart-canvas" width="160" height="120" data-chart='@json($chartData)'></canvas>
		</div>
	<?php } ?>
	<table class="item-rating-extended-criterias table table-hover">
		@foreach($rating->scores as $score)
			<tr class="item-rating-extended-criterias-criteria">
				<td class="align-middle"><strong>{{ $score->criteria->name }}</strong></td>
				<td class="text-right">
					@component('site.components.item.score', [
						'score' => $score->value,
						'class' => 'small-score-size'
					])
					@endcomponent
				</td>
			</tr>
		@endforeach
	</table>
</div>