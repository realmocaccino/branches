@extends('site.layouts.main.index')

@section('content-header')

	@include('site.layouts.user.components.header')

@endsection

@section('content')

    <div class="row" id="user-layout">
	    <div class="col-12">
            <div class="row">
	            <div class="col-12">
		            @if($head->getTitle() and !in_array($currentRouteName, ['user.index', 'account.index']))
			            <div class="row" id="user-layout-title">
				            <div class="col-12">
					            @component('site.components.title', [
						            'title' => $head->getInternalTitle(),
						            'class' => 'float-left'
					            ])
					            @endcomponent
					            <div class="float-right">
						            @yield('user_counter')
					            </div>
				            </div>
			            </div>
		            @endif
		            <div class="row" id="user-layout-content">
			            <div class="col-12">
				            @yield('user_content')
			            </div>
		            </div>
	            </div>
            </div>
		</div>
	</div>
	
@endsection