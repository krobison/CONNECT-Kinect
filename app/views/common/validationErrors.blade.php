@if($errors->has())
<div class="content_section">
    <ul>
    	@foreach ($errors->all() as $errorMessage)
    		<li> {{ $errorMessage }}</li>
    	@endforeach
    </ul>
</div>
@endif