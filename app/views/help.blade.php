@extends('common.master')

@section('additionalHeaders')
	{{ HTML::style('assets/css/helpcenter.css') }}
@stop

@section('content')
	<div class="newpost">
	    
	    <h3>New Help Post</h3>
	    
	    <hr>
	    
	    {{ Form::open(array('url' => 'createhelppost')) }}
	    
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
	   		{{ Form::textarea('content', null, array('class' => 'form-control',
													 'placeholder' => 'Content...',
													 'rows' => '5')) }}
	    </div>
	    
	    <hr>
	    
	    <div class="row">
	    	<div class ="col-xs-5 col-md-4">
	    	{{Form::submit('Post', array('class' => 'btn btn-lg btn-primary btn-block'))}}			
	    	</div>
	    </div>
	    	    	
	</div>
@stop