<?php
/**
* PHP version 5
*
* md-photo-blog : Markdown Blog for Photos
* Copyright 2012, Willi Thiel
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @copyright Copyright 2012, Willi Thiel
* @link http://ni-c.github.de/md-photo-blog
* @package md-photo-blog
* @subpackage md-photo-blog.app
* @since md-photo-blog v 0.1a
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/

/**
 * Home represents the home directory
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
		if (array_search(POSTS_DIRECTORY . DIRECTORY_SEPARATOR . 'init', $this->dirlist)!==false) {
			LessHelper::generate_css();
		}
	}
	
	public function get_content() {
		return array(
			'title' => 'md-photo-blog'
		);
	}
	
	public function get_template() {
		return "home";
	}
}