@if(Session::has('message'))
    <div class="content_section">
    	<p style="text-align: center;">{{ Session::get('message') }}</p>
    </div>
@endif