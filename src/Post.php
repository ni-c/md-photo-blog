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
		$this -> images = $this -> dir_to_array(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . IMAGE_SUBDIRECTORY, true, true, true);
		foreach ($this->images as $key => $value) {
			$this->images[$key] = str_replace(WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR, "", $value);
		}
	}

	/**
	 * Cache this post
	 */
	private function cache() {

		// Read files
		$files = $this -> dir_to_array(POSTS_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name, true, true, true);

		$cache_dir = WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name;
		$image_dir = WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . $this -> name . DIRECTORY_SEPARATOR . IMAGE_SUBDIRECTORY;

		@mkdir($cache_dir);
		@mkdir($image_dir);

		foreach ($files as $key => $value) {

			$filename = pathinfo($value, PATHINFO_FILENAME);

			// Resample JPG files
			$ext = strtolower(pathinfo($files[$key], PATHINFO_EXTENSION));
			if ($ext == 'jpg' || $ext = 'jpeg') {
				ImageHelper::resample($value, $image_dir . DIRECTORY_SEPARATOR . $filename . "." . $ext, DEFAULT_IMG_WIDTH);
			}
		}
	}

	/**
	 * Returns the template of the page
	 */
	protected function get_content() {
		return array(
			'layout_title' => 'md-photo-blog',
			'images' => $this->images,
		);
	}
	
	/**
	 * Returns the content for the template of the page
	 */
	protected function get_template() {
		return 'post';
	}

}
