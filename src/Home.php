<?php
/**
* PHP version 5
*
* photo-md-blog : Markdown Blog for Photos
* Copyright 2012, Willi Thiel
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @copyright Copyright 2012, Willi Thiel
* @link http://ni-c.github.de/photo-md-blog
* @package photo-md-blog
* @subpackage photo-md-blog.app
* @since photo-md-blog v 0.1a
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/

/**
 * Home class
 */
class Home extends Page {
	
	/**
	 * The list of posts in the posts directory
	 */
	private $dirlist = array();
	
	/**
	 * Create a new home 
	 * 
	 * @param $posts_directory The directory where the posts are saved
	 */
	function __construct() {
		$this->dirlist = $this->dir_to_array(POSTS_DIRECTORY);
	}

	/**
	 * Renders the page 
	 */
	public function render() {
		
	}
}