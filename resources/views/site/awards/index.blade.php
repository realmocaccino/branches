@extends('site.layouts.internal.index')

@section('internal_counter')

    <select id="awards-yearSelect" class="transform">
        @foreach($years as $year)
            <option value="{{ $year }}" @if($year == $currentYear) selected="selected" @endif>{{ $year }}</option>
        @endforeach
    </select>

@endsection

@section('internal_content')

    <div class="row" id="awards">
        <div class="col-12">
            @foreach($awards as $award)
                @component('site.components.item.game_spotlight', [
                    'category' => $award['award'],
                    'game' => $award['game']
                ])
                @endcomponent
            @endforeach
        </div>
    </div>

@endsection