@if(!$agent->isMobile())
    <ul id="game-modes">
        @foreach($game->summedUpModes() as $modeSlug => $modeName)
            @if(strpos($modeSlug, 'single') !== false)
                <li>
                    <img src="{{ asset('img/modes/singleplayer.png') }}" alt="{{ $modeName }}" title="{{ $modeName }}">
                </li>
            @elseif(strpos($modeSlug, 'co-op') !== false)
                <li>
                    <img src="{{ asset('img/modes/coop.png') }}" alt="{{ $modeName }}" title="{{ $modeName }}">
                </li>
            @elseif(strpos($modeSlug, 'competitive') !== false or strpos($modeSlug, 'mmo') !== false)
                <li>
                    <img src="{{ asset('img/modes/multiplayer.png') }}" alt="{{ $modeName }}" title="{{ $modeName }}">
                </li>
            @endif
        @endforeach
    </ul>
@endif