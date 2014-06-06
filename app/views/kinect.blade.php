@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/posts.css') }}
	{{ HTML::style('assets/css/select2.css') }}
	
	<style>
	h4 {
		margin:0px;
		padding:0px;
	}
	#games_heading:hover{ 
		background-color:orange;
	}
	#players_heading:hover{ 
		background-color:orange;
	}
	</style>
@stop

@section('title')
	CS Kinect
@stop

@section('content')
	<h2>CS Kinect</h2>
	<!-- Picture of Kinect system in Brown Building alcove -->
	<div "><img src ="assets/img/CS_Kinect.jpg" width = "50%" height = "50%"></div>
	<p>The Kinect system is a Microsoft Kinect camera that tracks hand motion to play a variety of games.</p>
			
	<!-- Lists off games and allow for voting. Only 1 vote per game by each user. -->
	<div id="games" class="panel panel-default">
		<div id="games_heading" class="panel-heading">
			<h4>Kinect Games</h4> 
		</div>
			<div id="games_body" class="panel-body">
			{{ View::make('votegames')
					->with('user', Auth::user())
					->with('kinectGames', $kinectGames) 
					->with('votes', $votes)}}
			</div>
	</div>
	
	<!-- Displays top ten players and their highscores -->
	<div id="players" class="panel panel-default">
		<div id="players_heading" class="panel-heading">
			<h4>Kinect Highscorers</h4> 
		</div>
			<div id="players_body" class="panel-body">
				<table border='2'>
				<tr><th></th><th>Name</th><th>Score</th></tr>		
				@foreach($kinectScores as $score) 
					<tr>
					<td> <a href="{{URL::to('profile', $score->id)}}"><img style="border-radius:50% 50% 50% 50%;" width="46" height ="46" src="assets/img/dummy.png"></a></td>
					<td >{{$score->first}}  {{$score->last}}</td>
					<td>{{$score->total_score}}</td>
					</tr>
				@endforeach
				</table>
			</div>
	</div>
		<script>
		// Hide and show sections on button press
		$('#games_heading').click(function() {
			$('#games_body').toggle(200);
		});
		
		$('#players_heading').click(function() {
			$('#players_body').toggle(200);
		});
		$(document).ready(function() {
			$('#games_body').hide();
			$('#players_body').hide();
		});
		
	</script>
@stop