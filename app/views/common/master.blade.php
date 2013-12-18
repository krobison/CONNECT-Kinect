<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	
	@yield('additionalHeaders')
	
	<title>CS CONNECT</title>
	
</head>

<body>

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
        			<li><a href="#">Messages</a></li>
    				<li><a href="#">Notifications</a></li>
    				</ul>
      
    				<ul class="nav navbar-nav navbar-right">
    					<li><a href="{{ URL::to('logout') }}">Logout</a></li>
    				</ul>
    	
    		</div>
    
    	</div>
    </div>
	

	
	<div class="container" style="padding-top: 70px; max-width: none !important; width: 970px">
	
		<div class="row">
			
			<div class="col-xs-2">
			
				{{-- Side Bar --}}
			
				<div class="affix">
				
				<p>{{ $user->first }} {{ $user->last }}</p>
				<p>{{ $user->email }}</p>
				<ul class="nav">
					<li><a href="{{ URL::to('newsfeed') }}">News Feed</a></li>
					<li><a href="{{ URL::to('profile/'.Auth::user()->id) }}">Profile</a></li>
					<li><a href="{{ URL::to('CSQuestion') }}"> CS Question</a></li>
					<li><a href="{{ URL::to('helpCenter') }}">Help Center</a></li>
					<li><a href="{{ URL::to('search') }}">Search</a></li>
				</ul>
				
				</div>
				
			</div>
			
			<div class="col-xs-10">
				
				{{-- Main Content Container --}}
			
				@yield('content')
			
			</div>
			
		</div>
	
	</div>
	
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

</body>
</html>