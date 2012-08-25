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

 require_once('vendor' . DIRECTORY_SEPARATOR . 'php-markdown' . DIRECTORY_SEPARATOR . 'markdown.php');
 
/**
 * The image subdirectory
 */
define("IMAGE_SUBDIRECTORY", "img");

/**
 * A post represents a single blog post
 */
class Post extends Page {

	/**
	 * Unique name of the post (= directory name)
	 */
	private $name = "";

	/**
	 * The URLs of the images in this post
	 */
	private $images = array();

	/**
	 * The title of the post
	 */
	private $title = "";
	
	/**
	 * The date of the post
	 */
	private $post_date = null;

	/**
	 * The text of the post
	 */
	private $text = "";

	/**
	 * Create a new home
	 *
	 * @param $posts_directory The directory where the posts are saved
	 */
	function __construct($name) {
		$this -> name = $name;

		// Create cached version if modified
		if (file_exists(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $name)) {
			if (filemtime(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $name) < filemtime(POSTS_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name)) {
				$this -> cache();
			}
		}

		// Create cached version if not exists
		if (!file_exists(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $name)) {
			$this -> cache();
		}

		// Create image array
		$this -> images = $this -> dir_to_array(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $name, true, true, true);
		foreach ($this->images as $key => $value) {
			$this->images[$key] = str_replace(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR, "", $value);
		}

		// Parse markdown file
		$mdcontent = file_get_contents(POSTS_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name . DIRECTORY_SEPARATOR . 'meta.md');
		$comments = explode("\n", substr($mdcontent, strpos($mdcontent, '/*')+2, strpos($mdcontent, '*/')-2));
		foreach ($comments as $key => $value) {
			if (strpos($value, "Title: ")!==false) {
				$this->title = trim(str_replace("Title: ", "", $value));
			}
			if (strpos($value, "Date: ")!==false) {
				$this->post_date = trim(str_replace("Date: ", "", $value));
			}
		}
		$this->text = Markdown(substr($mdcontent, strpos($mdcontent, '*/')+2));
	}

	/**
	 * Cache this post
	 */
	private function cache() {

		// Read files
		$files = $this -> dir_to_array(POSTS_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name, true, true, true);

		$cache_dir = WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name;

		@mkdir($cache_dir);

		foreach ($files as $key => $value) {

			$filename = pathinfo($value, PATHINFO_FILENAME);

			// Resample JPG files
			$ext = strtolower(pathinfo($files[$key], PATHINFO_EXTENSION));
			if ($ext == 'jpg' || $ext = 'jpeg') {
				ImageHelper::resample($value, $cache_dir . DIRECTORY_SEPARATOR . $filename . "." . $ext, DEFAULT_IMG_WIDTH);
			}
		}
	}

	/**
	 * Returns the template of the page
	 */
	protected function get_content() {
		return array(
			'title' => BLOG_TITLE . ' - ' . $this->title,
			'post_date' => $this->post_date,
			'post_title' => $this->title,
			'post_text' => $this->text,
			'post_images' => $this->images,
		);
	}
	
	/**
	 * Returns the content for the template of the page
	 */
	protected function get_template() {
		return 'post';
	}

}
