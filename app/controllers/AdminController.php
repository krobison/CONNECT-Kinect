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

		return Redirect::to('newsfeed')->with('message', '<div class="alert alert-success"> You have successfully deleted the account. </div>');
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
		}
		
		$post->delete();
		
		return Redirect::to('newsfeed');
		
		
		
		}

}