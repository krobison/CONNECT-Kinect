<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	
	@yield('additionalHeaders')
	
	<title>CS CONNECT</title>
	
</head>

<body style='background-color: #f5f5f5'>

	{{-- Script Includes --}}
	
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/jquery.stellar.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

	{{-- Top Bar --}}
	<div class='container' style='position: relative; width: 100%; height: 125px'>
	
		{{-- Color Bar --}}
		<div data-stellar-ratio='0.75' style='position: absolute; background-color: #3498db; top: 0px; height: 75px; left:0px; right:0px'>
		
			{{-- Title --}}
			<div class='container' style='line-height: 75px; width: 970px'>
				<p style='font-family: Geneva, Tahoma, Verdana, sans-serif; color: white; font-size: xx-large; text-shadow: 0px 1px 1px rgba(84, 84, 84, 0.5)'>@yield('title')</p>
			</div>
		
			{{-- Stripe in Color Bar --}}
			<div style="background-color: black; position: absolute; bottom: 0px; height: 5px; left: 0px; right: 0px; opacity: 0.05"></div>
		</div>
		
		{{-- Task Bar --}}
		<div style='position: absolute; top: 75px; height: 50; left:0px; right:0px; background-color: white;'>
		
		{{-- Content --}}
		<div class="container" style='max-width: none !important; width: 970px; line-height: 50px; font-family: Geneva, Tahoma, Verdana, sans-serif; color: grey'>
			<div class="btn-group" style='float: left'>
				<button class="btn dropdown-toggle sr-only" style='width: 200px; height: 43px; margin: 3px' type="button" id="dropdownMenu1" data-toggle="dropdown">
					{{ HTML::image('assets/img/csconnect.png', 'CS CONNECT', array('width' => '32px')) }} CS CONNECT <span class="label label-danger"> {{{Auth::user()->notifications->count()}}}</span>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li role="presentation" class="dropdown-header">Conversation Notifications</li>
					@foreach(Auth::user()->notifications()->where('type','=','tag')->get() as $notification)
						<li><a href="{{{URL::to('singlepost')}}}/{{{$notification->origin_id}}}"> {{{User::find($notification->initiator_id)->first}}} made a post with a tag from your profile. </a></li>
					@endforeach
					<li role="presentation" class="dropdown-header">Tag Notifications</li>
					@foreach(Auth::user()->notifications()->where('type','=','conversation')->get() as $notification)
						<li><a href="{{{URL::to('conversation')}}}/{{{$notification->origin_id}}}"> {{{User::find($notification->initiator_id)->first}}} responded in one of your conversations. </a></li>
					@endforeach
				</ul>
			</div>
			
			<a href='{{ URL::to('conversations') }}'>
				<span style='float: left; padding-left: 25px;'>
					<span class='glyphicon glyphicon-envelope'></span> CONVERSATIONS
				</span>
			</a>
			
			<a href="{{ URL::to('logout') }}"><span style="float: right">LOGOUT</span></a>
		</div>
		
			{{-- Stripe in Task Bar --}}
			<div style="background-color: black; position: absolute; bottom: 0px; height: 1px; left: 0px; right: 0px; opacity: 0.1"></div>
			
		</div>
	
	</div>

	{{-- Side Bar and Main Content --}}
	<div class="container" style="width: 100%;">
	
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

            </div>
            
            {{-- Main Content --}}
            <div class="col-xs-9" style="background-color: white">
                    @yield('content')
            </div>
            
            </div>
    </div>

</div>


        
<style>
        a {
                color: grey;
                -o-transition:.5s;
                -ms-transition:.5s;
                -moz-transition:.5s;
                -webkit-transition:.5s;
                transition:.5s;
        } 
        a:hover {
                color: #3498db;
        }
</style>

<script>
        $(function() {
                $.stellar();
        });
</script>

{{-- 
<style>
        sticky {
                position: absolute;
                top: 0;
        }
</style>

<script>
        var $window = $(window),
                $stickyElement = $('#the-sticky-div'),
                elementTop = $stickyElement.offset().top;
                
        $window.scroll(function() {
        console.log($stickyElement);
        $stickyElement.toggleClass('sticky', $window.scrollTop() > elementTop);
        });
</script>
--}}

</body>
</html>