<?php

class PostHelpOffer extends Eloquent {

	protected $table = 'postsHelpOffers';

	/**
	 *	Relationships.
	 */
	 
    public function post()
    {
        return $this->morphMany('Post', 'postable');
    }
}