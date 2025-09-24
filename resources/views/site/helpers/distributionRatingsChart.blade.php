<div class="distributionRatingsChart">
	@isset($bars['high'])
		<div class="distributionRatingsChartBar distributionRatingsChartBarHigh" title="{{ $bars['high']['total'] }} {{ str_plural(trans('helpers/distributionRatingsChart.rating'), $bars['high']['total']) }} {{ str_plural(trans('helpers/distributionRatingsChart.positive'), $bars['high']['total']) }}" style="width: {{ $bars['high']['width'] }}%;">{{ $bars['high']['total'] }}</div>
	@endisset
	@isset($bars['medium'])
		<div class="distributionRatingsChartBar distributionRatingsChartBarMedium" title="{{ $bars['medium']['total'] }} {{ str_plural(trans('helpers/distributionRatingsChart.rating'), $bars['medium']['total']) }} {{ str_plural(trans('helpers/distributionRatingsChart.neutral'), $bars['medium']['total']) }}" style="width: {{ $bars['medium']['width'] }}%;">{{ $bars['medium']['total'] }}</div>
	@endisset
	@isset($bars['low'])
		<div class="distributionRatingsChartBar distributionRatingsChartBarLow" title="{{ $bars['low']['total'] }} {{ str_plural(trans('helpers/distributionRatingsChart.rating'), $bars['low']['total']) }} {{ str_plural(trans('helpers/distributionRatingsChart.negative'), $bars['low']['total']) }}" style="width: {{ $bars['low']['width'] }}%;">{{ $bars['low']['total'] }}</div>
	@endisset
</div>