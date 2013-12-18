<?php

class PostQuestion extends Eloquent {

	protected $table = 'postsQuestion';

	/**
	 *	Relationships.
	 */
	 
    public function post()
    {
        return $this->morphMany('Post', 'postable');
    }
}