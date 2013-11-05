
<!DOCTYPE html>
<html>
	<head>
		<title>CONNECT - People</title>

		{{ HTML::style('css/LayoutGlobal.css') }}
		{{ HTML::style('css/LayoutLoggedIn.css') }}
		{{ HTML::style('css/LayoutMenu.css') }}
		{{ HTML::script('js/log.js') }}

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		{{ HTML::style('css/LayoutPeopleViewer.css') }}
		{{ HTML::style('css/LayoutSearch.css') }}
		{{ HTML::style('css/LayoutPaginate.css') }}

		{{ HTML::script('js/jquery-1.9.1.js') }}
		{{ HTML::script('jsdisablestate.js') }}
		{{ HTML::script('js/updateconnection.js') }}

	</head> 

	<body>
	
		{{ View::make('common.header') }}

		{{ View::make('common.menu') }}

		<div id="main">
		
			{{ View::make('common.sidebar') }}
			
			<div id="content">
				<div id="flash">
														</div>

				
				
						<div class="content_section">
				<div id="search_title">
											<h2>All People</h2>
									</div>

															<form method="get">
							<input type="hidden" name="show_search" value="true" />
							<input type="submit" value="Search People" class="button" id="show_search_people_button" />
						</form>
									
				<div class="clear">
				</div>

				<div class="paginate">
			</div>
				<div class="sort_order">
					<p>Sort Order:
												
																			 
						<a href="{{ URL::to('people') }}">
															<u>First Name</u>
													</a> |
													
						<a href="{{ URL::to('people?sort=last_name') }}">Last Name</a>
													
						</p>
				</div>

				@foreach ($users as $user)		
					{{ View::make('common.person')->with('user', $user) }}
				@endforeach

				{{ $users->links(); }}
					
				<div class="clear">
				</div>
			</div>
			
			</div>
		</div>

		{{ View::make('common.footer') }}

	</body>

</html>
