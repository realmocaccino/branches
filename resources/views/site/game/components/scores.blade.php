@if($game->isAvailable() or $game->total_critic_ratings)
    <section id="game-scores">
        @if($game->total_ratings)
            <div class="game-scores-col" id="game-scores-communityScore">
                <div class="game-scores-col-center">
                    <div class="game-scores-score">
                        <a href="{{ route('game.ratings', [$game->slug]) }}" title="@lang('game/components/index/scores.see_all_ratings')">
                            @component('site.components.item.score', [
                                'score' => $game->score,
                                'class' => 'game-score-size'
                            ])
                            @endcomponent
                        </a>
                    </div>
                    <div class="game-scores-description">
                        <h4>
                            <a href="{{ route('game.ratings', [$game->slug]) }}" title="@lang('game/components/index/scores.see_all_ratings')">
                                @lang('game/components/index/scores.community_score')
                            </a>
                        </h4>
                        <p class="descriptive">
                            @lang('game/components/index/scores.based_on')
                            @if($agent->isMobile())
                                {{ $game->total_ratings }} {{ trans_choice('game/components/index/scores.rating', $game->total_ratings) }}
                            @else
                                <a href="{{ route('game.ratings', [$game->slug]) }}">
                                    <strong>{{ $game->total_ratings }} {{ trans_choice('game/components/index/scores.rating', $game->total_ratings) }}</strong>
                                </a>
                                @if($game->total_reviews)
                                    @lang('game/components/index/scores.and') <a href="{{ route('game.reviews', [$game->slug]) }}"><strong>{{ $game->total_reviews }} {{ str_plural(trans('game/components/index/scores.review'), $game->total_reviews) }}</strong></a>
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if($game->total_critic_ratings)
            <div class="game-scores-col" id="game-scores-criticScore">
                <div class="game-scores-col-center">
                    <div class="game-scores-score">
                        @component('site.components.item.score', [
                            'score' => $game->critic_score,
                            'class' => 'game-score-size'
                        ])
                        @endcomponent
                    </div>
                    <div class="game-scores-description">
                        <h4>@lang('game/components/index/scores.critic_score')</h4>
                        <p class="descriptive">@lang('game/components/index/scores.based_on') {{ $game->total_critic_ratings }} {{ trans_choice('game/components/index/scores.rating', $game->total_critic_ratings) }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if($game->total_ratings and $game->total_critic_ratings)
            <div class="game-scores-col" id="game-scores-aggregateScore">
                <div class="game-scores-col-center">
                    <div class="game-scores-score">
                        @component('site.components.item.score', [
                            'score' => $game->aggregate_score,
                            'class' => 'game-score-size'
                        ])
                        @endcomponent
                    </div>
                    <div class="game-scores-description">
                        <h4>@lang('game/components/index/scores.aggregate_score')</h4>
                        <p class="descriptive">@lang('game/components/index/scores.based_on') {{ $game->total_aggregate_ratings }} {{ trans_choice('game/components/index/scores.rating', $game->total_aggregate_ratings) }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if($game->isAvailable())
            @isset($userRating)
                <div class="game-scores-col" id="game-scores-userScore">
                    <div class="game-scores-col-center">
                        <div class="game-scores-score">
                            <a class="dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}" title="@lang('game/components/index/scores.change_score')">
                                @component('site.components.item.score', [
                                    'score' => $userRating->score,
                                    'class' => 'game-score-size'
                                ])
                                @endcomponent
                            </a>
                            <span id="game-scores-userRatingPlatform" class="game-scores-scoreInfo" title="{{ $userRating->platform->name }}">
                                @component('site.components.item.platform', [
                                    'platform' => $userRating->platform
                                ])
                                @endcomponent
                            </span>
                        </div>
                        <div class="game-scores-description">
                            <h4>@lang('game/components/index/scores.my_score')</h4>
                            <p id="game-scores-userScore-buttons">
                                <a class="dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}"><span class="btn btn-extra-small btn-primary">@lang('game/components/index/scores.change')</span></a>
                                <a class="dialog" href="{{ route('rating.delete', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.delete', $game->slug) }}"><span class="btn btn-extra-small btn-danger">@lang('game/components/index/scores.delete')</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="game-scores-col" id="game-scores-addScore">
                    <div class="game-scores-col-center">
                        <div class="game-scores-score">
                            <a class="add-score dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}">
                                <span class="oi oi-plus"></span>
                            </a>
                        </div>
                        <div class="game-scores-description">
                            <h4>
                                <a class="dialog btn btn-outline-primary btn-sm" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}">
                                    @lang('game/components/index/scores.add_score')
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            @endisset
        @endif
    </section>
@endif