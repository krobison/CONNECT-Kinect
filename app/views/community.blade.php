@extends('common.master')

@section('title')
	COMMUNITY.
@stop

@section('additionalHeaders')

	<style type="text/css" media="screen">

	</style>
	{{ HTML::script('assets/js/d3.min.js') }}
	
	{{--
	<link rel="stylesheet" type="text/css" href="../../www/css/LayoutPeopleViewer.css">
	<link rel="stylesheet" type="text/css" href="../../www/css/LayoutGraph.css" />
	<script language="javascript" type="text/javascript" src="../../www/js/updateconnection.js"></script>
	--}}
	
	{{ HTML::style('assets/css/LayoutGraph.css') }}
	{{ HTML::script('assets/js/community/jit.js') }}
	
@stop

@section('content')
	<h2>Community Tool</h2>
	
	<p>
		An interactive was to search for users with similar interests. Zoom and pan with the mouse.
	</p>
	
	<hr>
	
	<a name="focus_graph"></a>
	
	<h3 id="header_name">{{ $header }}</h3>

	<div id="container">
	
		<div id="center_container">		
			<div id="infovis"></div>    
		</div>

		<div id="log">
		</div>

		<div id="legend">
		    @if ($user_view)
		    	<label>You are marked as a star</label>
		    @else 
		    	<label>The tags you are subscribed to are marked with a star. <a href="{{{URL::to('editprofile')}}}">Edit tags</a> </label>
		    @endif
		</div>

		@if ($user_view)
		    <div id="back_to_interests">
		    	<a href="community">&lt; Back to all tags</a>
		    </div>
		@endif
		
	</div>

	@if ($user_view)
		<div id="interest_list_view">
			<h3>List of People</h3>
				<ul>
					@if ($interests)
						@foreach ($interests as $interest)
							@if ($interest['is_mine'])
							
							<li class="my_interest">
								<a href="{{ URL::to('profile', array('id' => $interest['id'])) }}">
									{{{ $interest['name'] }}}
								</a>
							</li>
							
							@else
							
							<li>
								<a href="{{ URL::to('profile', array('id' => $interest['id'])) }}">
									{{{ $interest['name'] }}}
								</a>
							</li>
							
							@endif
						@endforeach
					@endif
				</ul>
		</div>
	@else
		<div class="content_section">
			<div id="interest_list_view">
				<h3>List of Hashtags</h3>

				<ul>
					@if ($interests)
						@foreach ($interests as $interest)
							@if ($interest['is_mine'])
							
							<li class="my_interest">
								<a href="community?hashtag={{ $interest['id'] }}">
									{{{ $interest['name'] }}}
								</a>
							</li>
							
							@else
							
							<li>
								<a href="community?hashtag={{ $interest['id'] }}">
									{{{ $interest['name'] }}}
								</a>
							</li>
							
							@endif
						@endforeach
					@endif
				</ul>
				
			</div>
		</div>
	@endif
	
	<!-- Loading all scripts at the end for performance-->
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	
	@if ($user_view)
		{{ HTML::script('assets/js/community/directedgraph_user.js') }}
	@else
		{{ HTML::script('assets/js/community/directedgraph.js') }}
	@endif

@stop
	
	
	