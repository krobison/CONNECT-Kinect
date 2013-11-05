<?php

class PeopleController extends BaseController {
	
	public function showPeople() {
		if (Input::get('sort') == 'last_name') {
			$users = Session::get('users', User::orderBy('last_name', 'ASC')->paginate(3));
			$users->appends(array('sort' => 'last_name'));
		} else {
			$users = Session::get('users', User::orderBy('first_name', 'ASC')->paginate(3));
		}
		return View::make('people')->with('users', $users);
	}
	
}