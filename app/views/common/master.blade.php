<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	
	@yield('additionalHeaders')
	
	<title>CS CONNECT</title>
	
</head>

<body>

	{{-- Script Includes --}}
	
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/jquery.stellar.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

	{{-- Top Bar --}}
	<div class='container' style='position: relative; width: 100%; height: 174px'>
	
		{{-- Color Bar --}}
		<div data-stellar-ratio='0.75' style='position: absolute; background-color: #3498db; top: 0px; height: 100px; left:0px; right:0px'>
		
			{{-- Title --}}
			<div class='container' style='line-height: 100px; width: 970px'>
				<p style='font-family: Geneva, Tahoma, Verdana, sans-serif; color: white; font-size: xx-large; text-shadow: 0px 1px 1px rgba(84, 84, 84, 0.5)'>@yield('title')</p>
			</div>
		
			{{-- Stripe in Color Bar --}}
			<div style="background-color: black; position: absolute; bottom: 0px; height: 5px; left: 0px; right: 0px; opacity: 0.05"></div>
		</div>
		
		{{-- Task Bar --}}
		<div style='position: absolute; top: 100px; height: 74; left:0px; right:0px'>
		
			{{-- Background With Opacity --}}
			<div class='container' style='background-color: white; opacity: 0.5;'></div>
		
			{{-- Content --}}
		<div class="container" style='max-width: none !important; width: 970px; line-height: 74px; font-family: Geneva, Tahoma, Verdana, sans-serif; color: grey'>
			<span style='float: left'>{{ HTML::image('assets/img/csconnect.png', 'CS CONNECT', array('width' => '32px')) }} CSCONNECT</span>
			
			<a href="{{ URL::to('logout') }}"><span style="float: right">LOGOUT</span></a>
		</div>
		
			{{-- Stripe in Task Bar --}}
			<div style="background-color: black; position: absolute; bottom: 0px; height: 1px; left: 0px; right: 0px; opacity: 0.1"></div>
		</div>
	
	</div>

	{{-- Side Bar and Main Content --}}
	<div class="container" style="width: 100%; background-color: #f5f5f5">
	
		<div class="container" style=" max-width: none !important; width: 970px; background-color: #f5f5f5">
			<div class="row">
				
				{{-- Side Bar --}}
				<div class="col-xs-3" style="padding-top: 20px;">
					
					<div class="list-group">
					@if (substr(Request::path(),0,7) == "profile" || Request::path() == "editprofile")
						<a href="{{ URL::to('profile/'.Auth::user()->id) }}" class="list-group-item active"><span class="glyphicon glyphicon-user"></span>   {{{ $user->first }}} {{{ $user->last }}}</a>
					@else
						<a href="{{ URL::to('profile/'.Auth::user()->id) }}" class="list-group-item"><span class="glyphicon glyphicon-user"></span>   {{{ $user->first }}} {{{ $user->last }}}</a>
					@endif
					<br>

					@if (Request::path() == "inbox")
						<a href="{{ URL::to('inbox') }}" class="list-group-item active"><span class="glyphicon glyphicon-inbox"></span>   Inbox <span class="badge">{{sizeof($messages)}}</span></a>
						<a href="{{ URL::to('oldmail') }}" class="list-group-item"><span class="glyphicon glyphicon-book"></span>   Read </a>
						<a href="{{ URL::to('sentmail') }}" class="list-group-item"><span class="glyphicon glyphicon-export"></span>   Sent </a>
						<br>
					@endif
					@if (substr(Request::path(),0,11) == "showmessage")
						<a href="{{ URL::to('inbox') }}" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span>   Inbox <span class="badge">{{sizeof($messages)}}</span></a>
						<a href="{{ URL::to('oldmail') }}" class="list-group-item"><span class="glyphicon glyphicon-book"></span>   Read </a>
						<a href="{{ URL::to('sentmail') }}" class="list-group-item"><span class="glyphicon glyphicon-export"></span>   Sent </a>
						<br>
					@endif
					@if (substr(Request::path(),0,11) == "oldmail")
						<a href="{{ URL::to('inbox') }}" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span>   Inbox <span class="badge">{{sizeof($messages)}}</span></a>
						<a href="{{ URL::to('oldmail') }}" class="list-group-item active"><span class="glyphicon glyphicon-book"></span>   Read </a>
						<a href="{{ URL::to('sentmail') }}" class="list-group-item"><span class="glyphicon glyphicon-export"></span>   Sent </a>
						<br>
					@endif
					@if (substr(Request::path(),0,11) == "sentmail")
						<a href="{{ URL::to('inbox') }}" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span>   Inbox <span class="badge">{{sizeof($messages)}}</span></a>
						<a href="{{ URL::to('oldmail') }}" class="list-group-item"><span class="glyphicon glyphicon-book"></span>   Read </a>
						<a href="{{ URL::to('sentmail') }}" class="list-group-item active"><span class="glyphicon glyphicon-export"></span>   Sent </a>
						<br>
					@endif

					@if (Request::path() == "cs_connect")
						<a href="{{ URL::to('cs_connect') }}" class="list-group-item active"><span class="glyphicon glyphicon-home"></span>   CS CONNECT</a>
					@else
						<a href="{{ URL::to('cs_connect') }}" class="list-group-item"><span class="glyphicon glyphicon-home"></span>   CS CONNECT</a>
					@endif

					@if (Request::path() == "newsfeed")
						<a href="{{ URL::to('newsfeed') }}" class="list-group-item active"><span class="glyphicon glyphicon-list"></span>   News Feed</a>
					@else
						<a href="{{ URL::to('newsfeed') }}" class="list-group-item"><span class="glyphicon glyphicon-list"></span>   News Feed</a>
					@endif

					@if (Request::path() == "CSQuestion" || Request::path() == "showPreviousQuestions")
						<a href="{{ URL::to('CSQuestion') }}" class="list-group-item active"><span class="glyphicon glyphicon-question-sign"></span>   CS Question</a>
					@else
						<a href="{{ URL::to('CSQuestion') }}" class="list-group-item"><span class="glyphicon glyphicon-question-sign"></span>   CS Question</a>
					@endif

					@if (Request::path() == "projects")
						<a href="{{ URL::to('projects') }}" class="list-group-item active"><span class="glyphicon glyphicon-hdd"></span> CS Projects</a>
					@else
						<a href="{{ URL::to('projects') }}" class="list-group-item"><span class="glyphicon glyphicon-hdd"></span> CS Projects</a>
					@endif

					@if (Request::path() == "helpCenter")
						<a href="{{ URL::to('helpCenter') }}" class="list-group-item active"><span class="glyphicon glyphicon-bullhorn"></span>   Help Center</a>
					@else
						<a href="{{ URL::to('helpCenter') }}" class="list-group-item"><span class="glyphicon glyphicon-bullhorn"></span>   Help Center</a>
					@endif	

					@if (Request::path() == "community")
						<a href="{{ URL::to('community') }}" class="list-group-item active"><span class="glyphicon glyphicon-globe"></span>   Community</a>
					@else
						<a href="{{ URL::to('community') }}" class="list-group-item"><span class="glyphicon glyphicon-globe"></span>   Community</a>
					@endif

					@if (Request::path() == "search")
						<a href="{{ URL::to('search') }}" class="list-group-item active"><span class="glyphicon glyphicon-search"></span>   Search</a>
					@else
						<a href="{{ URL::to('search') }}" class="list-group-item"><span class="glyphicon glyphicon-search"></span>   Search</a>
					@endif
						@yield('seeall')
				</div>
		
			