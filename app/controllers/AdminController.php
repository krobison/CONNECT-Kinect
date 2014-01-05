<?php

class AdminController extends BaseController {
	
	public function deleteUser(){
		$id = Input::get("id");
		
		if(!is_null(User::find($id)->picture)) {
			unlink(base_path().'/assets/img/profile_images/'.User::find($id)->picture);
		}

		DB::table('users')->where('id','=',$id)->delete();
		DB::table('posts')->where('user_id','=',$id)->delete();
		DB::table('questions')->where('user_id','=',$id)->delete();
		DB::table('upvotes')->where('user_id','=',$id)->delete();
		DB::table('hashtag_user')->where('user_id','=',$id)->delete();
		DB::table('message_user')->where('user_id','=',$id)->delete();
		DB::table('comments')->where('user_id','=',$id)->delete();
		DB::table('course_user')->where('user_id','=',$id)->delete();

		return Redirect::to('newsfeed')->with('message', 'You have successfully deleted the account.');
	}
	
	public function deletePost() {
		$id = Input::get("id");
		
		$post = Post::find($id);
		$comments = $post->comments;
		foreach($comments as $comment) {
			$comment->delete();
		}
		if($post->postable_type == 'PostHelpRequest') {
			DB::table('postsHelpRequests')->where('id','=',$post->postable_id)->delete();
		} else if($post->postable_type == 'PostHelpOffer') {
			DB::table('postsHelpOffers')->where('id','=',$post->postable_id)->delete();
		} else if($post->postable_type == 'PostProject') {
			$post_P = PostProject::find($post->postable_id);
			if(!is_null($post_P->screenshot)) {
				unlink(base_path().'/assets/img/csproject_images/'.$post_P->screenshot);
			}
			if(!is_null($post_P->file)) {
				unlink(base_path().'/assets/csproject_files/'.$post_P->file);
			}
			$post_P->delete();
		}
		
		DB::table('hashtag_post')->where('post_id','=',$post->id)->delete();
		
		$post->delete();
		
		return Redirect::to('newsfeed')->with('message', 'You have successfully deleted the post.');
	}
	
	public function deleteComment() {
		$id = Input::get("id");
		$comment = Comment::find($id);
		$comment->delete();
		
		return Redirect::back()->with('message', 'You have successfully deleted the comment.');
	}
	
	public function approveProject() {
		$id = Input::get("id");
		$post = Post::find($id);
		$post_P = PostProject::find($post->postable_id);
		$post_P->approved = '1';
		$post_P->save();
		$post->touch();
		
		return Redirect::back()->with('message', 'You have successfully approved the project.');
	}
	
	public function createCSQuestion() {
		try {
			// Create A Post in the db
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post->postable_type = 'PostQuestion';
			$post->language = Input::get('language');
			$post->code = Input::get('code');
			$post->save();
			
			// Add an entry in post_hashtag table to save post tags
			$hashtags = Input::get('hashtags');
			$hashtags = preg_split('/(?<!"),(?!")/',$hashtags[0]);
			foreach($hashtags as $tag) {
				// If the value is not numerical, the tag doesn't exist yet. Add it the the table.
				if(is_numeric($tag)) {
					Hashtag::find($tag)->posts()->attach($post);
				} else {
					$new_tag = new Hashtag;
					$new_tag->name = $tag;
					$new_tag->save();
					$new_tag->posts()->attach($post);
				}
			}
		} catch( Exception $e ) {
			//return View::make('debug', array('data' => Input::all()));
			return Redirect::back()->with('message', '<div class="alert alert-danger" > Your post cannot be created at this time, please try again later. </div>');
		}
		return Redirect::back();
		//return Redirect::back()->with('message', '<div class="alert alert-success"> Your post has been successfully created. </div>');
	}
}