@extends('site.layouts.internal.index')

@section('internal_content')

	<div id="notifications">
		@if($notifications->count())
			<ul id="notifications-list">
				@foreach($notifications as $notification)
					<li>
						<p><span class="notification-text">@if(!$notification->read_at) <em class="oi oi-media-record notification-new"></em> @endif {!! $notification->data['text'] !!}</span> <span class="notification-separator">&bullet;</span> <span class="notification-date">{!! $notification->created_at->diffForHumans() !!}</span></p>
					</li>
				@endforeach
			</ul>
			{{ $notifications->links() }}
		@else
			<p>@lang('notifications/index.no_notifications')</p>
		@endif
	</div>
	
	<?php $user->unreadNotifications->markAsRead(); ?>

@endsection
