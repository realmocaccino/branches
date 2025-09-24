@isset($score)
	@if(isset($classic))
		<div class="item-score-classic {{ $class ?? 'default-score-size' }}">{{ $score }}</div>
	@else
		<div class="item-score {{ $class ?? 'default-score-size' }}" data-size="{{ $class ?? 'default-score-size' }}" data-score="{{ $score }}"></div>
	@endif
@endisset