<?php

class PostFeedback extends Eloquent {

	protected $table = 'postsFeedback';

	/**
	 *	Relationships.
	 */
	 
    public function post()
    {
        return $this->morphMany('Post', 'postable');
    }
}