<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	
	@yield('additionalHeaders')
	
	<title>CS CONNECT</title>
	
</head>

<body>

	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

	{{-- Top Navigation Bar --}}
	
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    	<div class="container" style="max-width: 970px">
  
    		<div class="navbar-header">
    			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
    				<span class="sr-only">Toggle navigation</span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    			</button>
    			<a class="navbar-brand" href="#">CS CONNECT</a>
    		</div>
    
    		<div class="navbar-collapse bs-navbar-collapse collapse">
    	
    			<ul class="nav navbar-nav">
        			<li><a href="#">Messages <i> Not Working </i></a></li>
    				<li><a href="#">Notifications <i> Not Working </i></a></li>
    				</ul>
      
    				<ul class="nav navbar-nav navbar-right">
    					<li><a href="{{ URL::to('logout') }}">Logout</a></li>
    				</ul>
    	
    		</div>
    
    	</div>
    </div>
	
	<div class="container" style="padding-top: 70px; max-width: none !important; width: 970px">
	
		<div class="row">
			
			<div class="col-xs-3">
			
				{{-- Side Bar --}}
			
				<div class="affix">
				
				<p><a href="{{ URL::to('profile/'.Auth::user()->id) }}">{{{ $user->first }}} {{{ $user->last }}}</a></li></p>
				<p>{{{ $user->email }}}</p>
				<ul class="nav">
					<li><a href="{{ URL::to('cs_connect') }}"><span class="glyphicon glyphicon-home"></span>   CS CONNECT</a></li>
					<li><a href="{{ URL::to('newsfeed') }}"><span class="glyphicon glyphicon-list"></span>   News Feed</a></li>
					<li><a href="{{ URL::to('CSQuestion') }}"><span class="glyphicon glyphicon-pencil"></span>   CS Question</a></li>
					<li><a href="{{ URL::to('projects') }}"><span class="glyphicon glyphicon-folder-open"></span>   CS Projects</a></li>
					<li><a href="{{ URL::to('helpCenter') }}"><span class="glyphicon glyphicon-bullhorn"></span>   Help Center</a></li>
					<li><a href="{{ URL::to('community') }}"><span class="glyphicon glyphicon-globe"></span>   Community</a></li>
					<li><a href="{{ URL::to('search') }}"><span class="glyphicon glyphicon-search"></span>   Search</a></li>
					@yield('seeall')
				</ul>
				
				</div>
				
			</div>
			
			<div class="col-xs-9">
				
				{{-- Main Content Container --}}
			
				@yield('content')
			
			</div>
			
		</div>
	
	</div>

</body>
</html>