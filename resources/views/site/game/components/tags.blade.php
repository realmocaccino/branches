<section id="game-tags">
    @if($game->isEarlyAccess())
        <a id="game-tags-earlyAccess" class="btn btn-primary" href="{{ route('list', 'in-early-access') }}">@lang('game/components/tags.early_access')</a>
    @elseif($game->isComing())
        <a id="game-tags-countdown" class="btn btn-primary" href="{{ route('list', 'next-releases') }}">{{ $game->countdownByDays() }} {{ str_plural(trans('game/components/tags.countdown_day'), $game->countdownByDays()) }} {{ str_plural(trans('game/components/tags.countdown_left'), $game->countdownByDays()) }}</a>
    @elseif($game->isNewRelease())
        <a id="game-tags-isNewRelease" class="btn btn-success" href="{{ route('list', 'latest-releases') }}">@lang('game/components/tags.new_release')</a>
    @elseif($game->isGettingOldToday())
        <a id="game-tags-isGettingOldToday" class="btn btn-primary" href="{{ route('list', 'birthday-today') }}">@lang('game/components/tags.birthday')</a>
    @elseif($game->isUndated())
        <a id="game-tags-noDate" class="btn btn-primary" href="{{ route('list', 'most-anticipated-games') }}">@lang('game/components/tags.no_date')</a>
    @else
        <a id="game-tags-release" class="btn btn-secondary" href="{{ route('tag', ['year', $game->release->year]) }}">{{ $game->release->year }}</a>
    @endif
    @if($game->genres->count())
        {!! Site::tagLinkCollection('genre', $game->genres, 'secondary') !!}
    @endif
    @if($game->themes->count())
        {!! Site::tagLinkCollection('theme', $game->themes, 'secondary') !!}
    @endif
    @if($game->characteristics->count())
        {!! Site::tagLinkCollection('characteristic', $game->characteristics, 'secondary') !!}
    @endif
    @if($game->isExclusive())
        {!! Site::createTagLink('platform', $game->platforms->first(), 'secondary') !!}
    @endif
    @if($game->series())
        {!! Site::createTagLink('franchise', $game->series(), 'secondary') !!}
    @endif
    @if($game->owner())
        {!! Site::createTagLink('developer', $game->owner(), 'secondary') !!}
    @endif
</section>