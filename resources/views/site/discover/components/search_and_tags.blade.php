<div class="row" id="discover">
    <div class="col-12">
        <form id="discover-form" method="get" action="{{ route('discover') }}">
            <select id="discover-select" class="form-control" name="keywords[]" multiple="multiple" required="required" data-placeholder="@lang('discover/index.combine_keywords')">
                <option value="" disabled></option>
                @if($keywords)
                    @foreach($keywords as $slug => $name)
                        <option value="{{ $slug }}" @if(isset($activeKeywords) and in_array($slug, $activeKeywords)) selected="selected" @endif>{{ $name }}</option>
                    @endforeach
                @endif
            </select>
            <button id="discover-button" class="btn btn-site">@lang('discover/index.submit')</button>
        </form>
    </div>
    @if(isset($favorites) and $favorites->count())
        <div class="col-12" id="discover-favorites">
            @lang('discover/index.what_you_most_like')
            <ul>
                @foreach($favorites as $favorite)
                    <li>
                        <span class="btn btn-secondary btn-sm">{{ $favorite->name }}</span>	
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>