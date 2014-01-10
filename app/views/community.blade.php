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

	<a name="focus_graph"></a>
	
	<h3 id="header_name">{{ $header }}</h3>

	<div id="container">
	
		<div id="center_container">		
			<div id="infovis"></div>    
		</div>

		<div id="log">
		</div>

		@if ($user_view)
		    {if $no_connections or $no_users or $private_connections}
		    	<div id="notice">
		    		{if $private_connections}
		    			Your connections are marked as "private" and will not
		    			be shown in this graph.
		    			<br />
		    			To get the full use of this tool, make your connections 
		    			"public" on the Profile page.
		    			<br />
		    			<br />
		    		{/if}
		    		{if $no_connections}
		    			Don't see any connections? Check out the list of people in this interest area below
		    			to find others to connect with.
		    		{elseif $no_users}
		    			It appears there are no people with an interest in {$header}.
		    		{/if}
		    	</div>
		    {/if}
		@endif

		<div id="legend">
		    @if ($user_view)
		    	<div id="has_met">	
		    	</div>
		    	<label>Has Met</label>
		    	<div id="has_messaged">	
		    	</div>
		    	<label>Has Messaged</label>
		    	<div id="wants_to_meet">	
		    	</div>
		    	<label>Wants to Meet</label>
		    @else
		    	<label>Your hashtags are stars</label>
		    @endif
		</div>

		@if ($user_view)
		    <div id="view_most_connected_person">
		    	<a href="./index.php?interest_area={$selected_interest.short_name}&view_most_connected#focus_graph">
		    		View Most Connected Person
		    	</a>
		    </div>

		    <div id="back_to_interests">
		    	<a href="./index.php#focus_graph">&lt; Back to all interests</a>
		    </div>
		@endif
		
	</div>

	@if ($user_view)
	    <p id="graph_note">
	    	Note: Edges are only shown for the connections made by the user in the center of the graph.
	    </p>
	@endif

	@if ($user_view)
		<div class="content_section">
			<div id="connection_list_view">
				<h2>People Visible in Graph</h2>

				{foreach $visibleUsers as $user}
					{include file = '../partials/peopleviewer.tpl' user = $user}
				{/foreach}
			</div>

			<div class="back_to_interests_link">
				<a href="./index.php#focus_graph">&lt; Back to all interests</a>
			</div>
		</div>

		<div class="content_section">
			<div id="people_list_view">
				<h2>Other People Interested in {$header}</h2>

				{foreach $users as $user}
					{include file = '../partials/peopleviewer.tpl' user = $user}
				{/foreach}
			</div>

			<div class="back_to_interests_link">
				<a href="./index.php#focus_graph">&lt; Back to all interests</a>
			</div>
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
								<a href="../../modules/community/?interest_area={$interest.short_name}#focus_graph">
									{{ $interest['short_name'] }}
								</a>
							</li>
							
							@else
							
							<li>
								<a href="../../modules/community/?interest_area={$interest.short_name}#focus_graph">
									{{ $interest['short_name'] }}
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
		{{ HTML::script('assets/js/community/hypertree.js') }}
	@else
		{{ HTML::script('assets/js/community/directedgraph.js') }}
	@endif

@stop
	
	
	