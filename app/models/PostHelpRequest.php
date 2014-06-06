<?php

class PostHelpRequest extends Eloquent {

	protected $table = 'postsHelpRequests';

	/**
	 *	Relationships.
	 */
	 
    public function post()
    {
        return $this->morphMany('Post', 'postable');
    }
}