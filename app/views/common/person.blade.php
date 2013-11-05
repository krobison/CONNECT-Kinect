<div class="profile">
	<div class="profile_name" style="color: white">
		<strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
	</div>

	
	<div class="profile_picture">
		@if ($user->photo)
			{{ HTML::image('img/profile_images/'.$user->photo->path) }}		
		@else
			{{ HTML::image('img/defaultImage.png') }}
		@endif
	</div>

	<div class="profile_info">

		@if (isset($user->organization) && $user->organization != '')
			<div class="profile_organization">
				<label>Organization: </label> {{ $user->organization }}
			</div>
		@endif


		<div class="profile_email">
			<label>Email: </label> {{ $user->email }}
		</div>

		@if (isset($user->state) && $user->state != '')
			<div class="profile_about">
				<label>State: </label> {{ $user->state }}
			</div>
		@endif
		
		@if (isset($user->city) && $user->city != '')
			<div class="profile_about">
				<label>City: </label> {{ $user->city }}
			</div>
		@endif
		
		@if (isset($user->webpage) && $user->webpage != '')
			<div class="profile_about">
				<label>Webpage: </label> {{ $user->webpage }}
			</div>
		@endif
		
		@if (isset($user->about) && $user->about != '')
			<div class="profile_about">
				<label>About {{ $user->first_name }}: </label> {{ $user->about }}
			</div>
		@endif
		
		@if ($user->roles()->count() > 0)
			<div class="profile_about">
				<label>Roles: </label>
				@foreach ($user->roles as $role)
					{{ $role->name }}
				@endforeach
			</div>
		@endif
		
		@if ($user->interests()->count() > 0)
			<div class="profile_about">
				<label>Interest Areas: </label>
				@foreach ($user->interests as $interest)
					{{ $interest->name }}
				@endforeach
			</div>
		@endif

		<div class="profile_facebook">
					</div>
	</div>



	<div class="clear"></div>
</div>