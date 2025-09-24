@extends('site.layouts.internal.index')

@section('internal_content')

	<div class="row" id="categories">
		<div class="col-12">
			<div class="row" id="themes">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byTheme')</h2>
						<ul>
							@foreach($themes as $theme)
								<li>
									<a href="{{ route('tag', ['theme', $theme->slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('theme', $theme->slug) }}"></img>
										<p>{{ $theme->name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="genres">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byGenre')</h2>
						<ul>
							@foreach($genres as $genre)
								<li>
									<a href="{{ route('tag', ['genre', $genre->slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('genre', $genre->slug) }}"></img>
										<p>{{ $genre->name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="years">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byYear')</h2>
						<ul>
							@foreach($years as $year)
								<li>
									<a href="{{ route('tag', ['year', $year]) }}">
										<img src="{{ Site::getCategoryThumbnail('year', $year) }}"></img>
										<p>{{ $year }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="criterias">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byCriteria')</h2>
						<ul>
							@foreach($criterias as $criteria)
								<li>
									<a href="{{ route('tag', ['criteria', $criteria->slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('criteria', $criteria->slug) }}"></img>
										<p>{{ $criteria->name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="scores">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byScore')</h2>
						<ul>
							@foreach($byScore as $slug => $name)
								<li>
									<a href="{{ route('tag', ['list', $slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('byScore', $slug) }}"></img>
										<p>{{ $name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="modes">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byMode')</h2>
						<ul>
							@foreach($modes as $mode)
								<li>
									<a href="{{ route('tag', ['mode', $mode->slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('mode', $mode->slug) }}"></img>
										<p>{{ $mode->name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="characteristics">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byCharacteristic')</h2>
						<ul>
							@foreach($characteristics as $characteristic)
								<li>
									<a href="{{ route('tag', ['characteristic', $characteristic->slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('characteristic', $characteristic->slug) }}"></img>
										<p>{{ $characteristic->name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="platforms">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.byPlatform')</h2>
						<ul>
							@foreach($platforms as $platform)
								<li>
									<a href="{{ route('tag', ['platform', $platform->slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('platform', $platform->slug) }}"></img>
										<p>{{ $platform->name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="lists">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.lists')</h2>
						<ul>
							@foreach($lists as $slug => $name)
								<li>
									<a href="{{ route('list', $slug) }}">
										<img src="{{ Site::getCategoryThumbnail('list', $slug) }}"></img>
										<p>{{ $name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
			<div class="row" id="collections">
				<div class="col-12">
					<section>
						<h2>&#9632; @lang('categories/index.collections') Nota do Game</h2>
						<ul>
							@foreach($collections as $slug => $name)
								<li>
									<a href="{{ route('collection.index', ['nota-do-game', $slug]) }}">
										<img src="{{ Site::getCategoryThumbnail('collection', $slug) }}"></img>
										<p>{{ $name }}</p>
									</a>
								</li>
							@endforeach
						</ul>
					</section>
				</div>
			</div>
		</div>
	</div>

@endsection