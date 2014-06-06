<?php

class KinectController extends BaseController {
	
	public function showProjects() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "kinect accessed";
		$log->save();
		$votes = DB::table('kinectVoted')
			->get();
		$kinectGames = DB::table('kinectGames')
						->orderBy('kinectGames.name', 'ASC')
						->skip(0)
						->take(4)
						->get();
		$kinectScores = DB::table('kinectScores')
						->leftJoin('users', 'users.id', '=', 'kinectScores.user_id')
						->orderBy('kinectScores.total_score', 'DESC')
						->skip(0)
						->take(10)
						->get();
		return View::make('kinect')
			->with('user', Auth::user())
			->with('kinectGames', $kinectGames)
			->with('votes', $votes)
			->with('kinectScores', $kinectScores);
	}
	public function showGames() {
		$name = Input::get('name');
		$upVotes = Input::get('upVotes');
		$id = Input::get('id');
		DB::table('kinectVoted')->insert(array('idGame' => $id.$name));
		//update upvote
		DB::table('kinectGames')
			->where('name', '=', $name)
			->update(array('upVotes' => $upVotes));
		$kinectGames = DB::table('kinectGames')
						->orderBy('kinectGames.name', 'ASC')
						->skip(0)
						->take(4)
						->get(0);
		return View::make('votegames')
			->with('user', Auth::user())
			->with('kinectGames', $kinectgames);
	}
}