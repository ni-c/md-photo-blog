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

class JadeFactory {

	/**
	 * Creates a new Jade instance and returns it
	 */
	public static function create() {
		
		// Create Jade stuff
		$dumper = new PHPDumper();
		$dumper -> registerVisitor('tag', new AutotagsVisitor());
		$dumper -> registerFilter('javascript', new JavaScriptFilter());
		$dumper -> registerFilter('cdata', new CDATAFilter());
		$dumper -> registerFilter('php', new PHPFilter());
		$dumper -> registerFilter('style', new CSSFilter());

		// Initialize parser & Jade
		$parser = new Parser(new Lexer());
		return new Jade($parser, $dumper);
	}

}
