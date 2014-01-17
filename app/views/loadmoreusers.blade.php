@foreach($results as $result)

@if($type == 'name')
	<div class="numNames"></div>
@elseif($type == 'bio')
	<div class="numBios"></div>
@endif

	<div style="margin-bottom:16px;padding:8px;border:1px #CCCCCC solid;border-radius:4px;"> 
				<div class="row">
					<div class="picture">
						<a href="{{URL::to('profile', $result->id)}}">
						@if(is_null($result->picture))
							{{ HTML::image('assets/img/dummy.png', 'profile picture', array('width' => '128', 'height' => '128')) }}
						@else
							{{ HTML::image('assets/img/profile_images/'.$result->picture, 'profile picture', array('width' => '128', 'height' => '128')) }}
						@endif
						</a>
					</div>
					<div class="info">
					<span>
					<h3><a href="{{URL::to('profile', $result->id)}}">{{{ $result->first }}} {{{ $result->last }}} </a></h3>
					</span>
					
					<span>
					<?php $strippedBio = strip_tags($result->bio); ?>
					@if (strlen($strippedBio) > 55)
	                   <p> {{{ substr($strippedBio,0,55)."..." }}} </p> 
	                @else
	                   <p>{{{ $strippedBio }}} </p> 
	                @endif
					</span>

					<!-- <span class="infolabel"><b>Classes:</b></span> </br>
					<span>
						@foreach(User::find($result->id)->courses as $course)
							@if (!empty($searchCourses))
								@foreach($searchCourses as $searchCourse)
									@if($course->id == $searchCourse->id)
										<span class="courselabelmatch">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
									@endif
								@endforeach 
							@endif
						@endforeach
						@foreach(User::find($result->id)->courses as $course)
							<?php $t = false ?>
							@if (!empty($searchCourses))
								@foreach($searchCourses as $searchCourse)
									@if($course->id == $searchCourse->id)
										<?php $t = true ?>
									@endif
								@endforeach 
							@endif
							@if(!$t)
								<span class="courselabel">{{{$course->prefix}}}{{{$course->number}}} - {{{$course->name}}}</span>
							@endif
						@endforeach
					</span> -->
						
					</div>
				</div>
				
			</div>
@endforeach