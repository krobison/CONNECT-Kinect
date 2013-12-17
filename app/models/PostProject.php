<?php

class PostProject extends Eloquent {

	protected $table = 'postsProjects';

	/**
	 *	Relationships.
	 */
	 
    public function post()
    {
        return $this->morphMany('Post', 'postable');
    }
}