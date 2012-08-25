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

require "vendor" . DIRECTORY_SEPARATOR . "lessphp" . DIRECTORY_SEPARATOR . "lessc.inc.php";
 
/**
 * Helper class to create less from php
 */
class LessHelper {

	public static function generate_css() {
		$css_dir = WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'css';
		if (!file_exists($css_dir)) {
			mkdir($css_dir);
		}
		$less = new lessc;
		$less::ccompile(VIEWS_DIRECTORY . DIRECTORY_SEPARATOR . 'custom.less', $css_dir . DIRECTORY_SEPARATOR . 'custom.css');
	}
}
