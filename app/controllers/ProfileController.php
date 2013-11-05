<?php

class ProfileController extends BaseController {
	
	public function showProfile() {
		return View::make('profile')->with('user', Auth::user());
	}
	
	public function editProfile() {
		$validator = User::validate(Input::all());
		
		
/*
		Input::file('image')->move($profileImagesDirectory);
		if (Input::hasFile('image')) {
			dd(Input::file('image'));
		}
*/
		
				
		if ($validator->fails()) {
			// There is a way to return errors to know exactly which validations failed.
			// However could not get to function correctly.
			return Redirect::to('profile')
				->withErrors($validator);
		} else {		
			// Find user by primary key.
			$id = Input::get('id');
			$user = User::find($id);
			
			// General information.
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
			$user->organization = Input::get('organization');
			$user->about = Input::get('about');
			$user->state = Input::get('state');
			$user->city = Input::get('city');
			$user->webpage = Input::get('webpage');
			
			// General information requires save.
			$user->save();
			
			// Roles relationship update.
			$rolesArray = array();
			$rolesCount = Role::all()->count();
			for ($i = 0; $i < $rolesCount; $i++) {
				array_push($rolesArray, Input::get('roles.'.$i));
			}
			$user->roles()->sync($rolesArray);
			
			// Interests relationship update.
			$interestsArray = array();
			$interestsCount = Interest::all()->count();
			for ($i = 0; $i < $interestsCount; $i++) {
				array_push($interestsArray, Input::get('interests.'.$i));
			}
			$user->interests()->sync($interestsArray);
			
			// Picture upload...
			$profileImagesDirectory = base_path().'/img/profile_images';
			$file = Input::file('image');
			
			// If input exists, begin process.
			if ($file) {
				// If user has a photo already, delete it first.
				if ($user->photo) {
					// Delete the photo.
					File::delete($profileImagesDirectory.'/'.$user->photo->path);
					// Delete the relationship.
					$user->photo->delete();
				}
				
				// Then upload the file, make the relation.
				$filename = str_random(32).'.'.$file->getClientOriginalExtension();
				$file->move($profileImagesDirectory, $filename);
				$photo = new Photo(array('path' => $filename));
				$user->photo()->save($photo);
			}
			
			// Then go back to profile page with message.
			return Redirect::to('profile')
				->with('message', 'Profile updated successfully!');
		}
	}
	
}