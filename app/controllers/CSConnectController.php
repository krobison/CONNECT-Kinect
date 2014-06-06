<?php

class CSConnectController extends BaseController {
	
	public function showCs_connect() {
		$posts = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostFeedback')->limit(5)->get();

		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "cs_connect accessed";
		$log->save();
		
		// Calculate user contribution score ORDER BY COUNT(p.user_id) DESC;
		//SELECT u.first, u.last, COUNT(c.user_id)
		//FROM users u
		//JOIN comments c ON u.id = c.user_id
		//GROUP BY c.user_id
		//ORDER BY u.id
		
		$users = User::select('id', 'first', 'last')->get()->toArray();
		$posts_score = User::select(DB::raw('users.id, COUNT(posts.user_id)'))->leftjoin('posts', 'users.id', '=', 'posts.user_id')->groupBy('posts.user_id')->orderBy('users.id')->get()->toArray();
		$comments_score = User::select(DB::raw('users.id, COUNT(comments.user_id)'))->leftJoin('comments', 'users.id', '=', 'comments.user_id')->groupBy('comments.user_id')->orderBy('users.id')->get()->toArray();

		$contributions = array();
		
		// Add all the users names and id's to an array
		foreach ($users as $user) {
			$contributions[$user['id']] = array( 'first' => $user['first'], 'last' => $user['last']);
		}
		
		// Add the number of posts for the user to the array
		foreach ($posts_score as $field) {
			$contributions[$field['id']]['post_count'] = $field['COUNT(posts.user_id)'];
		}
		
		// Add the number of comments for the user to the array
		foreach ($comments_score as $field) {
			$contributions[$field['id']]['comment_count'] = $field['COUNT(comments.user_id)'];
		}
		
		// Calculate the scores for each of the users
		foreach ($contributions as $id => $user) {
			$score = 0;
			if(isset($user['comment_count'])) {
				$score = $user['comment_count'];
			} else {
				$contributions[$id]['comment_count'] = 0;
			}
			
			if(isset($user['post_count'])) {
				$score = $score + $user['post_count'];
			} else {
				$contributions[$id]['post_count'] = 0;
			}
			
			$contributions[$id]['score'] = $score;
		}
		
		// Remove Thomas Brown (id = 64) and the Connect Admin (id = 108)
		unset($contributions[64]);
		unset($contributions[108]);
		
		// Sort the data by score
		function cmp_by_optionNumber($a, $b) {
			return $b["score"] - $a["score"];
		}
		usort($contributions, "cmp_by_optionNumber");
		
		$contributions = array_slice($contributions,0,9);

		return View::make('cs_connect')
			->with('user', Auth::user())
			->with('posts', $posts)
			->with('contributions', $contributions);
	}
	
	
	
	
}