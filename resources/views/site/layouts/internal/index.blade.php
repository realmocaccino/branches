@extends('site.layouts.main.index')

@section('content')

    <div class="row" id="internal">
	    <div class="col-12">
		    <div id="internal-container" @if(isset($smaller) and $smaller) class="internal-smaller" @endif>
	            @if($head->getTitle() and (!isset($noTitle) or $noTitle == false))
		            <div class="row">
			            <div class="col-12">
							<div id="internal-header">
								<div id="internal-marking"></div>
								<h2 id="internal-title">{!! $head->getInternalTitle() !!}</h2>
								<div id="internal-counter" class="float-right">
									@yield('internal_counter')
								</div>
							</div>
			            </div>
		            </div>
	            @endif
	            <div class="row">
		            <div class="col-12">
			            <div id="internal-content">
				            @yield('internal_content')
			            </div>
		            </div>
	            </div>
            </div>
	    </div>
    </div>

@endsection