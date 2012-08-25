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
 * Directory that contains the post files
 */
define("POSTS_DIRECTORY", getcwd() . DIRECTORY_SEPARATOR . 'posts');

/**
 * Directory that contains the post files
 */
define("VIEWS_DIRECTORY", getcwd() . DIRECTORY_SEPARATOR . 'views');

/**
 * Caching directory
 */
define("WEBROOT_DIRECTORY", getcwd() . DIRECTORY_SEPARATOR . 'webroot');

/**
 * Default image width
 */
define("DEFAULT_IMG_WIDTH", 800);

/**
 * Enable / disable caching
 */
define("CACHE_ENABLED", false);
