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
 * Page class
 */
abstract class Page {

	/**
	 * Get an array that represents directory tree
	 *
	 * @param string $directory     Directory path
	 * @param bool $recursive         Include sub directories
	 * @param bool $listDirs         Include directories on listing
	 * @param bool $listFiles         Include files on listing
	 * @param regex $exclude         Exclude paths that matches this regex
	 */
	protected function dir_to_array($directory, $recursive = false, $listDirs = true, $listFiles = false, $exclude = '') {
		$array_items = array();
		$skip_by_exclude = false;
		$handle = opendir($directory);
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				preg_match("/(^(([\.]){1,2})$|(\.(svn|git|md))|(Thumbs\.db|\.DS_STORE))$/iu", $file, $skip);
				if ($exclude) {
					preg_match($exclude, $file, $skip_by_exclude);
				}
				if (!$skip && !$skip_by_exclude) {
					if (is_dir($directory . DIRECTORY_SEPARATOR . $file)) {
						if ($recursive) {
							$array_items = array_merge($array_items, dir_to_array($directory . DIRECTORY_SEPARATOR . $file, $recursive, $listDirs, $listFiles, $exclude));
						}
						if ($listDirs) {
							$file = $directory . DIRECTORY_SEPARATOR . $file;
							$array_items[] = $file;
						}
					} else {
						if ($listFiles) {
							$file = $directory . DIRECTORY_SEPARATOR . $file;
							$array_items[] = $file;
						}
					}
				}
			}
			closedir($handle);
		}
		return $array_items;
	}
	
	/**
	 * Render the page
	 */
	abstract function render();

}
