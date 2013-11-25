<!DOCTYPE html>
<html>

<head>

	{{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/helpcenter.css') }}
	
</head>

<body>
	<div class="page-header">
		{{ HTML::image('assets/img/Connect_Logo.png') }}
	</div>

	<div class="content"> 
		<div class="newpost">
			{{ Form::open(array('url' => 'createpost')) }}
			
			<div class="form-group">
				<label class="radio-inline">
				{{ Form::radio('help_request', '1') }} 
					Help Request
				</label>
				<label class="radio-inline">
				{{ Form::radio('help_request', '0') }}
					Help Offer
				</label>
			</div>
			<hr>
			
			<div class="form-group">
				<label class="checkbox-inline">
				{{ Form::checkbox('help_type[]', '1') }}
					In the comments
				</label>
				<label class="checkbox-inline">
				{{ Form::checkbox('help_type[]', '2') }}
					In person
				</label>
				<label class="checkbox-inline">
				{{ Form::checkbox('help_type[]', '3') }}
					Skype/Hangouts/Video Chat
				</label>
			</div>
			<hr>
			
			<div class="form-group">
				<label class="radio-inline">
				{{ Form::radio('anonymous', '1') }} 
					Post Anonymously
				</label>
				<label class="radio-inline">
				{{ Form::radio('anonymous', '0') }}
					Post as Yourself
				</label>
			</div>
			<hr>
			
			<div class="form-group">
			{{ Form::textarea('content', null, array(
			'class' => 'form-control',
			'placeholder' => 'Content...',
			'rows' => '5'
			)) }}
			</div>
			<hr>
			
			<div class="row">
				<div class ="col-xs-5 col-md-4">
				{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
				</div>
			</div>		
		</div>
	</div>
	
	
	<div id="footer">
		<div class="container">
			<p class="text-muted credit">©2013 Toilers research group, Colorado School of Mines 		{{ HTML::image('assets/img/mines_logo.png') }}	{{ HTML::image('assets/img/toilers.png') }} </p>
		</div>
	</div>
	
	{{ HTML::script('assets/js/jquery-2.0.3.min.js') }}
</body>
</html>