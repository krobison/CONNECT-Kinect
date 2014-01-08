<?php

include('helpers/lib_autolink.php');

class PostController extends BaseController {

	public function addPostCommentNotifications($user,$cId){
			$user = User::find($user);
			if ($user->id != Auth::user()->id){
				$not = new Notification;
				$not->user_id = $user->id;
				$not->initiator_id = Auth::user()->id;
				$not->type = 'postComment';
				$not->origin_id = $cId;
				$not->save();
			}
	}

	public function createComment() {
		try {
			if (Input::get('content') != ''){
				$comment = new Comment;
				
				// Linkify the content
				$comment->content = autolink(Input::get('content'));
				$comment->user_id = Input::get('user_id');
				$comment->post_id = Input::get('post_id');
				$comment->language = Input::get('language');
				$comment->code = Input::get('code');
				$comment->save();

				$post = Post::find($comment->post_id);
				$owner = $post->user_id;

				$this->addPostCommentNotifications($owner,$comment->post_id);
				$user_id['user_id'] = Auth::user()->id;
				Log::info('comment made', $user_id);

				return Redirect::back()->with('message', "You have commented successfully");
			} else{
				return Redirect::back()->with('message', "You must type something");
			}
		} catch( Exception $e ) {

				return Redirect::back()->with('message', "You have commented unsuccessfully");
		}
	}
	
	public function addTagNotifications($tags,$sender_id,$post_id) {

			// Get an array of all the tag ids
			$hashtags = $tags->lists('id');
	
			// Get all users that have any of the hashtags (this took forever to figure out)
			$uninformed_users = DB::table('users')
			->whereExists(function($query) use ($hashtags)
			{
					$query->select(DB::raw(1))
							  ->from('hashtag_user')
							  ->whereRaw('hashtag_user.user_id = users.id')
							  ->whereIn('hashtag_user.hashtag_id',$hashtags);
			})
			->get();
			
			foreach($uninformed_users as $user) {
				if(Auth::user()->id != $user->id) {
					$not = new Notification;
					$not->user_id = $user->id;
					$not->initiator_id = $sender_id;
					$not->type = 'tag';
					$not->origin_id = $post_id;
					$not->save();
				}
			}
			
	}

	public function upvotePostAJAX() {
			$post = Post::find(Input::get('post_id'));
			$user = Auth::user();
			
			//return $post->id;


			$upvote = Upvote::where('user_id', '=', $user->id)->where('post_id', '=', $post->id)->count();

			if ($upvote > 0) {
					Upvote::where('user_id', '=', $user->id)->where('post_id', '=', $post->id)->delete();
					$post->upvotes = $post->upvotes - '1';
					$post->save();
					return json_encode(array("data" => $post->postupvotes->count(),"upOrDown" => "down"));
			}

			else {
					try {
							$upvote = new Upvote;
							$upvote->user_id = $user->id;
							$upvote->post_id = $post->id;
							$upvote->save();
							$post->upvotes = $post->upvotes + '1';
							$post->save();

							return json_encode(array("data" => $post->postupvotes->count(),"upOrDown" => "up"));

					} catch( Exception $e ) {

							return json_encode(array("data" => $post->postupvotes->count(),"upOrDown" => "error"));
					}
			}
	
	
	}
	
	public function upvotePost() {
			$post = Post::find(Input::get('post_id'));
			$user = Auth::user();

			$upvote = in_array($user->id, $post->postupvotes->lists('user_id'));

			if ($upvote) {
					Upvote::where('user_id', '=', $user->id)->where('post_id', '=', $post->id)->delete();
					$post->upvotes = $post->upvotes - '1';
					$post->save();
					return Redirect::back()->with('message', "You have upvoted successfully");
			}

			else {
					try {

							$upvote = new Upvote;
							$upvote->user_id = Input::get('user_id');
							$upvote->post_id = Input::get('post_id');
							$upvote->save();
							$post->upvotes = $post->upvotes + '1';
							$post->save();

							return Redirect::back()->with('message', "You have upvoted successfully");

					} catch( Exception $e ) {

							dd($e);

							return Redirect::back()->with('message', "You have upvoted unsuccessfully");
					}
			}
	}

	public function showSinglePost($id) {
			$post = Post::find($id);
			$user = Auth::user();
			
			if($post->postable_type == 'PostProject' && $post->postable->approved == '0' && $user->admin == '0') {
					return Redirect::to('newsfeed')->with('user', $user);
			}
	
			return View::make('singlepost')
					->with('user', $user)
					->with('post', $post);
	}
	
	// Render the view
	public function showPost() {
			return View::make('post');
	}
	
	// Ajax. Returns all users as a JSON object.
	public function getUsers() {
			return  User::all();
	}
	
	// Form. Add user.
	public function addUser() {

			// Create a new User object
			$post = new Post;
	
			// Assign user attributes based on POST data
			//$user->name = $_POST[type]
			$post->user_id = $_POST['user_id'];
			$post->content = $_POST['content'];
			$post->upvotes = $_POST['upvotes'];

			// Save the user to the database
			$post->save();

			return;
	}

	public function deleteUserComment() {
			$id = Input::get("id");
			$comment = Comment::find($id);
			if(Auth::user()->id == $comment->user_id) {
				$comment->delete();
				return Redirect::back()->with('message', 'You have successfully deleted the comment.');
			}
			Log::error("Security: User " . $id . " attempted to delete a comment (" . $comment->id . ") for which permissions weren't granted. Comment belongs to " . $comment->user_id . ".");
			return Redirect::back()->with('message', 'The server rejected your deletion.');
	}

	public function saveEditComment() {
			$id = Input::get("id");
			$comment = Comment::find($id);
			
			// Make sure the user who is doing the editing is actually the user who the comment belongs to!
			if($comment->user_id != Auth::user()->id) {
				Log::error("User " . Auth::user()->id . " attempted to edit a comment for which permissions were not granted. Content: " . $content);
				return Redirect::back()->with('message', 'The server rejected your edit. This incident has been logged.');
			}
						
			$content = Input::get("toSave".$id);
			
			// Linkify any content (see include('helpers/lib_autolink.php');)
			$content = autolink($content);

			$code = Input::get("toSaveCode".$id);
			$newCode = Input::get("toSaveNewCode".$id);
			$language = Input::get("toSaveLanguage".$id);
			if (!empty($content)) {
					$comment->content = $content;
			}
			if (!empty($newCode)) {
					$comment->code = $newCode;
					$comment->language = strtolower($language);
			}
			if (!empty($code)) {
					if ($code == "hideCode") {
							$comment->code = "";
					} else{
							$comment->code = $code;
					}
			}
			$comment->save();

			return Redirect::back()->with('message', 'You have successfully updated your comment.');
	}
	
	public function searchPosts() {
			$hashtags = Input::get('hashtags');
			$content = Input::get('content');
			$sort = Input::get('sort');
			$oldhashtags = NULL;
			$logText = "";
			
			$query = DB::table('posts');
			
			if(!empty($hashtags)) {
					$query->leftJoin('hashtag_post', 'posts.id', '=', 'hashtag_post.post_id')->whereIn('hashtag_post.hashtag_id', $hashtags);
					$oldhashtags = DB::table('hashtags')
							->whereIn('id',$hashtags)
							->get();
			}
			
			if($content != '') {
					$query->where('content', 'like', '%'.$content.'%');
			}
			
			if($sort[0] == '1') {
					$query->orderBy('upvotes', 'DESC');
			}
			
			$posts = $query->orderBy('id', 'DESC')->take(5)->get();

			if (!empty($content)) {
				$logText = $logText . $content . ",";
			}

			if (!empty($oldhashtags)) {
				$logText = $logText . "with hashtags: ";
				for ($i = 0; $i < sizeof($oldhashtags); ++$i) {
					$logText = $logText . $oldhashtags[$i]->name . ",";
				}
			}

			if (isset($sort)) {
				$logText = $logText . "sorted by upvotes";
			}

			$user_id['user_id'] = Auth::user()->id;
			Log::info('search made for ' . $logText, $user_id);
							
			return View::make('newsfeed')
					->with('user', Auth::user())
					->with('oldhashtags', $oldhashtags)
					->with('oldcontent', $content)
					->with('oldsort', $sort)
					->with('posts', $posts);
			
	}
	
	public function loadMorePosts() {
			$lastPostId = Input::get('lastpost');
			$content = Input::get('content');
			$sort = Input::get('sort');
			$hashtags = Input::get('hashtags');
			
			
			$query = DB::table('posts');
			
			if(!empty($hashtags)) {
					$query->leftJoin('hashtag_post', 'posts.id', '=', 'hashtag_post.post_id')->whereIn('hashtag_post.hashtag_id', $hashtags);
			}
			
			if($content != '') {
					$query->where('content', 'like', '%'.$content.'%');
			}
			
			if($sort == '1') {
					$query->orderBy('upvotes', 'DESC');
			}
			
			$posts = $query->where('id', '<', $lastPostId)->orderBy('id', 'DESC')->take(5)->get();
			
			
			if(empty($posts)) {
				return;
			}
			return View::make('loadmoreposts')
			->with('user', Auth::user())
			->with('posts', $posts)
			->with('type', 'GeneralPost');
	
	}
	
	public function createProjectPost() {

		try {
			$post_P = new PostProject;
			$validator = Validator::make(Input::all(), PostProject::$rules);
			if($validator->passes()) {
				$post_P->link = Input::get('link');
				$screenshot = Input::file('screenshot');
					if($screenshot) {
						$extension = $screenshot->getClientOriginalExtension();
						$newFilename = str_random(25) . "." . $extension;
						$destinationPath = base_path() . '/assets/img/csproject_images';
						$uploadSuccess = Input::file('screenshot')->move($destinationPath, $newFilename);
						if($uploadSuccess) {
							$post_P->screenshot = $newFilename;
						}
					}
			} else {
				Log::error("Validation Failure: ".$validator->messages());
				return Redirect::back()->with('message', '<div class="alert alert-danger">There was a problem making your post: '.$validator->messages().'</div>');;
			}
			$file = Input::file('file');
				if($file) {
					$extension = $file->getClientOriginalExtension();
					$newFilename = str_random(25) . "." . $extension;
					$destinationPath = base_path() . '/assets/csproject_files';
					$uploadSuccess = Input::file('file')->move($destinationPath, $newFilename);
					if($uploadSuccess) {
						$post_P->file = $newFilename;
					}
				}
		
			$post_P->save();
			
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = autolink(Input::get('content')); // Linkify the content
			$post_P->post()->save($post);
		
			// Create db associations for tags, add new tags to hashtag table
			PostController::addTags(Input::get('hashtags'),$post);
			
			// Generate notifications for each tag selected
			$this->addTagNotifications($post->hashtags,Auth::user()->id,$post->id);

		} catch( Exception $e ) {
			//return View::make('debug', array('data' => Input::all()));
			return Redirect::back()->with('message', 'There was an error making your post. Exception '.$e);
		}

		$user_id['user_id'] = Auth::user()->id;
		Log::info('project posted', $user_id);

		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	
	public function createHelpRequestPost() {
	
		try {
			// First add a PostHelpRequest to the PostHelpRequest table
			$post_HR = new PostHelpRequest;
			$post_HR->anonymous = Input::get('anonymous');
			$post_HR->save();

			// Then add a Post to the Posts table, associating it with the PostHelpRequest through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = autolink(Input::get('content'));
			$post->language = Input::get('language');
			$post->code = Input::get('code');
			$post_HR->post()->save($post);
			
			// Create db associations for tags, add new tags to hashtag table
			PostController::addTags(Input::get('hashtags'),$post);
			
		} catch( Exception $e ) {
			//return View::make('debug', array('data' => Input::all()));
			return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		$user_id['user_id'] = Auth::user()->id;
		Log::info('help request post', $user_id);
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	
	public function createHelpOfferPost() {
	
		try {	
			// Create A Post in the db
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = autolink(Input::get('content'));
			$post->postable_type = "PostHelpOffer";
			$post->save();
			
			// Create db associations for tags, add new tags to hashtag table
			PostController::addTags(Input::get('hashtags'),$post);
			
		} catch( Exception $e ) {
			//return View::make('debug', array('data' => Input::all()));
			return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}

		$user_id['user_id'] = Auth::user()->id;
		Log::info('help offer post', $user_id);
		
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}

	public function giveFeedback() {
		try {
			// First add a PostHelpRequest to the PostHelpRequest table
			$post_F = new PostFeedback;
			$post_F->save();

			// Then add a Post to the Posts table, associating it with the PostQuestion through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = autolink(Input::get('content'));
			$post_F->post()->save($post);
				
		} catch( Exception $e ) {
				//return View::make('debug', array('data' => Input::all()));
				return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back();
		//return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	
	// Create Post Functions
	public function createGeneralPost() {								
		try {
			// Create A Post in the db
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = autolink(Input::get('content'));
			$post->language = Input::get('language');
			$post->code = Input::get('code');
			$post->postable_type = "PostGeneral";
			$post->save();
			
			// Create db associations for tags, add new tags to hashtag table
			PostController::addTags(Input::get('hashtags'),$post);
			
			// Generate notifications for each tag selected
			$this->addTagNotifications($post->hashtags,Auth::user()->id,$post->id);
			$user_id['user_id'] = Auth::user()->id;
			Log::info('general post created', $user_id);
				
		} catch( Exception $e ) {
			//return View::make('debug', array('data' => Input::all()));
			return Redirect::back()->with('message', '<div class="alert alert-danger" > Your post cannot be created at this time, please try again later. </div>');
		}
		return Redirect::back();
		//return Redirect::back()->with('message', '<div class="alert alert-success"> Your post has been successfully created. </div>');
	}

	// Create Post Helper Functions
	public static function addTags($hashtags,$post) {
		$hashtags = preg_split('/(?<!"),(?!")/',$hashtags[0]);
		foreach($hashtags as $tag) {
			// If the value is not numerical, the tag doesn't exist yet. Add it to the the table.
			if(is_numeric($tag)) {
					Hashtag::find($tag)->posts()->attach($post);
			} else {
				// Only save tags longer than 3 characters (not including whitespace)
				if(strlen(preg_replace('/\s+/', '', $tag)) > 2) {
						$new_tag = new Hashtag;
						$new_tag->name = $tag;
						$new_tag->reserved = 0;
						$new_tag->save();
						$new_tag->posts()->attach($post);
				}
			}
		}
	}
}