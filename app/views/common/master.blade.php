<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	<style>
	#affix-y {
		position : static;
	}
	#notification-box {
		overflow-y: auto;
		max-height:600px;
		width:504px;
	}
	.notification:hover {
		background-color: #F5F5F5 ;
	}
	</style>
	
	@yield('additionalHeaders')
	
	<title>CS CONNECT</title>
	
	<link rel="shortcut icon" href="{{URL::to('assets/img/favicon.ico')}}">
	
</head>

@if (isset($onLoad))
	<body style='background-color: #f5f5f5' onload="{{ $onLoad }}">
@else
	<body style='background-color: #f5f5f5' class='test'>
@endif

	{{-- Script Includes --}}
	
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

	{{-- Top Bar --}}
	<div class='container' style='position: relative; width: 100%; height: 100px'>
	
		{{-- Color Bar --}}
		<div data-stellar-ratio='0.75' style='position: absolute; background-color: #3498db; top: 0px; height: 75px; left:0px; right:0px'>
		
			{{-- Title --}}
			<div class='container' style='line-height: 75px; width: 970px'>
				<p style='font-family: Geneva, Tahoma, Verdana, sans-serif; color: white; font-size: xx-large; text-shadow: 0px 1px 1px rgba(84, 84, 84, 0.5); float: left'>@yield('title')</p>
				<a href="{{ URL::to('logout') }}" style='float:right'><p style='font-family: Geneva, Tahoma, Verdana, sans-serif; color: white;'>LOGOUT</p></a>
			</div>
		
			{{-- Stripe in Color Bar --}}
			<div style="background-color: black; position: absolute; bottom: 0px; height: 5px; left: 0px; right: 0px; opacity: 0.05"></div>
		</div>


	</div>

	{{-- Side Bar and Main Content --}}
	<div class="container" style="width: 100%;">
	
		<div class="container" style=" max-width: none !important; width: 970px; background-color: #f5f5f5">
			<div class="row">
				
				{{-- Side Bar --}}
				<div class="col-xs-3">
				
				<div id='affix-y' style='width: 210px; z-index:1;'>
					
					<div class="list-group">
					{{-- Profile --}}
					@if (substr(Request::path(),0,7) == "profile" || Request::path() == "editprofile")
						<a href="{{ URL::to('profile/'.Auth::user()->id) }}" class="list-group-item active"><span class="glyphicon glyphicon-user"></span>   {{{ $user->first }}} {{{ $user->last }}}</a>
					@else
						<a href="{{ URL::to('profile/'.Auth::user()->id) }}" class="list-group-item"><span class="glyphicon glyphicon-user"></span>   {{{ $user->first }}} {{{ $user->last }}}</a>
					@endif
					
					{{-- Conversations --}}
					@if ((Request::path() == 'conversations')||(substr(Request::path(),0,16) == "showConversation"))
						<a href="{{ URL::to('conversations') }}" class="list-group-item active"><span class="glyphicon glyphicon-envelope"></span>   Conversations</a>
					@else
						<a href="{{ URL::to('conversations') }}" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span>   Conversations</a>
					@endif
					
					{{-- Notifications --}}
					<div class='dropdown'>
					@if (Auth::user()->notifications()->count() > 0)
						<a href='#' class='list-group-item' data-toggle='dropdown'>
						<span class='glyphicon glyphicon-exclamation-sign'></span> Notifications 
						<span style='float:right'>
							@if( Auth::user()->notifications()->where('read','=','0')->count() > 0)
								<span id="not-count" class="label label-danger">{{ Auth::user()->notifications()->where('read','=','0')->count() }}</span>
								<span id="caret-icon" class="caret"></span>
							@else
								<span id="not-count" class="label label-deafult" style="background-color:rgb(150,150,150)">0</span>
								<span id="caret-icon" class="caret"></span>
							@endif
						</span>
						</a>
					@else
						<a href='#' class='list-group-item'>
						<span class='glyphicon glyphicon-exclamation-sign'></span> Notifications 
						<span style='float:right'>
							<span id="not-count" class="label label-deafult" style="background-color:rgb(150,150,150)">0</span>
							<span id="caret-icon" class="caret" style="visibility:hidden"></span>
						</span>
						</a>
					@endif
					
					@if (Auth::user()->notifications->count() >0)
						<ul id="notification-box" class="dropdown-menu" role="menu">
							@if(Auth::user()->notifications()->whereRaw('(Type="conversationCreated" OR Type="conversationReply" OR Type="conversationAdd")')->count() >0)
							<li role="presentation" class="dropdown-header">Conversation Notifications</li>
								@foreach(Auth::user()->notifications()->whereRaw('(Type="conversationCreated" OR Type="conversationReply" OR Type="conversationAdd")')->orderBy('id', 'desc')->get() as $notification) </li>
									{{ View::make('common.notification')->with('notification', $notification) }}
								@endforeach
							@endif
							@if(Auth::user()->notifications()->where('type','=','tag')->count() >0)
							<li role="presentation" class="dropdown-header">Tag Notifications</li>
								@foreach(Auth::user()->notifications()->where('type','=','tag')->orderBy('id', 'desc')->get() as $notification)
									{{ View::make('common.notification')->with('notification', $notification) }}
								@endforeach
							@endif
							@if(Auth::user()->notifications()->where('type','=','postComment')->count() >0)
							<li role="presentation" class="dropdown-header">Post Notifications</li>
								@foreach(Auth::user()->notifications()->where('type','=','postComment')->orderBy('id', 'desc')->get() as $notification)
									{{ View::make('common.notification')->with('notification', $notification) }}
								@endforeach
							@endif
						</ul>
					@endif
					</div>
					
					{{-- Break --}}
					<br>

					{{-- CS CONNECT --}}
					@if (Request::path() == "cs_connect")
						<a href="{{ URL::to('cs_connect') }}" class="list-group-item active"><span class="glyphicon glyphicon-home"></span>   CS CONNECT</a>
					@else
						<a href="{{ URL::to('cs_connect') }}" class="list-group-item"><span class="glyphicon glyphicon-home"></span>   CS CONNECT</a>
					@endif

					{{-- Newsfeed --}}
					@if (Request::path() == "newsfeed")
						<a href="{{ URL::to('newsfeed') }}" class="list-group-item active"><span class="glyphicon glyphicon-list"></span>   News Feed</a>
					@else
						<a href="{{ URL::to('newsfeed') }}" class="list-group-item"><span class="glyphicon glyphicon-list"></span>   News Feed</a>
					@endif

					{{-- CS Question --}}
					@if (Request::path() == "CSQuestion" || Request::path() == "showPreviousQuestions")
						<a href="{{ URL::to('CSQuestion') }}" class="list-group-item active"><span class="glyphicon glyphicon-question-sign"></span>   CS Question</a>
					@else
						<a href="{{ URL::to('CSQuestion') }}" class="list-group-item"><span class="glyphicon glyphicon-question-sign"></span>   CS Question</a>
					@endif

					{{--  CS Kinect --}}
					@if (Request::path() == "kinect")
						<a href="{{ URL::to('kinect') }}" class="list-group-item active"><span class="glyphicon glyphicon-hand-up"></span> CS Kinect</a>
					@else
						<a href="{{ URL::to('kinect') }}" class="list-group-item"><span class="glyphicon glyphicon-hand-up"></span> CS Kinect</a>
					@endif
					
					{{--  CS Projects --}}
					@if (Request::path() == "projects")
						<a href="{{ URL::to('projects') }}" class="list-group-item active"><span class="glyphicon glyphicon-hdd"></span> CS Projects</a>
					@else
						<a href="{{ URL::to('projects') }}" class="list-group-item"><span class="glyphicon glyphicon-hdd"></span> CS Projects</a>
					@endif

					{{-- Help Center --}}
					@if (Request::path() == "helpCenter")
						<a href="{{ URL::to('helpCenter') }}" class="list-group-item active"><span class="glyphicon glyphicon-bullhorn"></span>   Help Center</a>
					@else
						<a href="{{ URL::to('helpCenter') }}" class="list-group-item"><span class="glyphicon glyphicon-bullhorn"></span>   Help Center</a>
					@endif	
					
					{{-- Community --}}
					@if (Request::path() == "community")
						<a href="{{ URL::to('community') }}" class="list-group-item active"><span class="glyphicon glyphicon-globe"></span>   Community</a>
					@else
						<a href="{{ URL::to('community') }}" class="list-group-item"><span class="glyphicon glyphicon-globe"></span>   Community</a>
					@endif

					{{-- Search --}}
					@if (Request::path() == "search")
						<a href="{{ URL::to('search') }}" class="list-group-item active"><span class="glyphicon glyphicon-search"></span>   User Search</a>
					@else
                        <a href="{{ URL::to('search') }}" class="list-group-item"><span class="glyphicon glyphicon-search"></span>   User Search</a>
                    @endif
					
					{{-- Admin --}}
					@if (Auth::User()->admin == '1')
					@if (Request::path() == "admin")
						<a href="{{ URL::to('admin') }}" class="list-group-item active"><span class="glyphicon glyphicon-search"></span>   Admin Tools</a>
					@else
                        <a href="{{ URL::to('admin') }}" class="list-group-item"><span class="glyphicon glyphicon-search"></span>   Admin Tools</a>
                    @endif
                    @endif
					
                    {{-- Moar --}}
                    @yield('seeall')
					</div>
					
					</div>

            </div>
            
            {{-- Main Content --}}
            <div class="col-xs-9" style="background-color: white">
                    @yield('content')
            </div>
            
            </div>
    </div>

</div>

{{ HTML::style('assets/css/notification.css') }}
<script>
	$('.dropdown-menu').click(function(e) {
		e.stopPropagation();
	});
	// Notification bar scrolling depends on window size
	$(document).ready(function(){
		$('#notification-box').css({
			'max-height': window.innerHeight-300
		});
	});
	$( window ).resize(function() {
		$('#notification-box').css({
			'max-height': window.innerHeight-300
		});
	});
</script>

<script>
var navigationBar = $("#affix-y");
var topOffset = parseInt(navigationBar.css('top')); //Grab the top position top first
var offset = 80;
var adjustScrollBar = function() {
	if( $(window).scrollTop() > offset ) {
		var viewportAdjustement = 0;
		
		if($(window).width() >= 999) {
			viewportAdjustement = (1585 - $(window).width())/2;
		} else {
			viewportAdjustement = (1585 - 999)/2;
		}
		
		navigationBar.css({
			'top': '20px',
			'left': 323 - $(window).scrollLeft() - viewportAdjustement,//'323px' ,
			'position' : 'fixed'
		});
	} else {
		navigationBar.css({
			'top': 'null',
			'left': 'null',
			'position' : 'static'
		});
	}
}
$(window).scroll(function(){
	adjustScrollBar();
});
$(window).resize(function(){
	adjustScrollBar();
});
</script>

<script>
	$( ".close" ).click(function(event) {
		event.stopPropagation();
		$( event.target ).closest( ".close" ).html('{{HTML::image("assets/img/spinner.gif", "none", array("width" => "20", "height" => "20", "class" => "img-circle"))}}');
		var not_id = $( event.target ).closest(".notification").attr('data');

		$.ajax({
			url: "{{{URL::to('deleteNotification')}}}",
			context: document.body,
			data: {"data": not_id},
			dataType: 'json',
			type: 'POST',
			success: function (res) {
				if(res != "0") {
					if( $( event.target ).closest( "li" ).attr('read') == 0 ) {
						$("#not-count").html($("#not-count").html()-1);
						if($("#not-count").html() == 0) {
							$('#caret-icon').attr("style","visibility:hidden");
							$("#not-count").attr("style","background-color:rgb(150,150,150)");
						}
					}
					$( event.target ).closest( "li" ).hide('slow').remove();
				}
			}
		});

	});
</script>
        
<style>
        a {
            -o-transition:.5s;
            -ms-transition:.5s;
            -moz-transition:.5s;
            -webkit-transition:.5s;
            transition:.5s;
        } 
        a:hover {
            color: #2980b9;
        }
</style>


</body>
</html>