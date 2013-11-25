<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	
	<title>CS CONNECT</title>
	
</head>

<body>

	{{-- Top Navigation Bar --}}
	
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container" style="width: 970px !important">
      
        <div class="navbar-header">
        	<a class="navbar-brand" href="#">CS CONNECT</a>
        </div>
        
        <div class="navbar-collapse collapse">
        	
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
	
	{{-- Main Content Container --}}
	
	<div class="container" style="padding-top: 70px; max-width: none !important; width: 970px">
	
		<div class="row">
			
			<div class="col-xs-3">
				<p>sup breh </p>
				<p>{{ $user->first }} {{ $user->last }}</p>
				<p>{{ $user->email }}</p>
				<p>mini profile view</p>
				<ul class="nav">
					<li><a href="#">Hello</a></li>
					<li><a href="#">World</a></li>
					<li><a href="#">Again</a></li>
					<li><a href="#">Two</a></li>
				</ul>
			</div>
			
			<div class="col-xs-9">
			
			@foreach ($posts as $post)
				{{ View::make('common.newsfeedPost')->with('post', $post) }}
			@endforeach
			
			</div>
			
		</div>
	
	</div>
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
	{{ HTML::script('assets/js/bootstrap.min.js') }}

</body>
</html>