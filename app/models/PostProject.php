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
	
	public static $rules = array(
		'file' => 'required_without:link|mimes:zip|max:2000',
		'link' => 'required_without:file|url',
		'screenshot' => 'required|image|max:2000'
	);
}