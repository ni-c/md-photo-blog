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
 * class autoloader
 */
function __autoload($classname) {
	
	$autoloaddirs = array(
		'src/',
		'src/vendor/jade.php/src/Everzet/Jade/',
		'src/vendor/jade.php/src/Everzet/Jade/Dumper/',
		'src/vendor/jade.php/src/Everzet/Jade/Filter/',
		'src/vendor/jade.php/src/Everzet/Jade/Lexer/',
		'src/vendor/jade.php/src/Everzet/Jade/Node/',
		'src/vendor/jade.php/src/Everzet/Jade/Visitor/',
	);
		
	foreach ($autoloaddirs as $key => $value) {
		if (file_exists($value . $classname . '.php')) {
			include $value . $classname . '.php';
		}
	}
}

/**
 * debug function
 */
function debug($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

/**
 * Load config file
 */
require_once 'config.inc.php';

//$Home = new Home(POSTS_DIRECTORY);
//$Home->render();
$Post = new Post("2012-08-25-Bumblebee");
$Post->render();
