<?php

include(app_path().'/purify/HTMLPurifier.auto.php');

class Post extends Eloquent {

	/*
	 *	Relationships.
	 */
	 
	public function user() {
		return $this->belongsTo('User');
	}
		
	public function comments() {
		return $this->hasMany('Comment');
	}
	    
    public function images() {
        return $this->hasMany('Images');
    }
	
	public function hashtags() {
		return $this->belongsToMany('Hashtag');
	}
	
	public function postable() {
        return $this->morphTo();
    }

    public function postupvotes() {
    	return $this->hasMany('Upvote');
    }
	
	// Helper function
	public function getPurifiedContent() {
		$pureconfig = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($pureconfig);
		return $purifier->purify($this->content);
	}

	// This really isn't a model function, however, I need to do a bunch of logic on 
	// data from the file system and it would be worse to put the logic in the blade template -- Thomas
	// (probably should move to controller though it any one is interested)
	public static function getSupportedLanguages() {
		// Look in the "assets/js/ace" directory to see what languages have supporting .js files
		$files = scandir(getcwd() . '/assets/js/ace/');
		
		// Remove all files that don't begin with "mode-" and end with ".js", these are not language scripts
		$pattern = '/mode-*.*.js/';
		$modeFiles = preg_grep($pattern, $files);
		
		// Remove the leading "mode-" and trailing ".js"
		$pattern = array('/mode-/','/.js/');
		$replace = array('','');
		$matches = preg_filter($pattern, $replace, $modeFiles);
		
		return $matches;
	}
}