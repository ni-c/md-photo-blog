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
 * ImageHelper class
 *
 * Helper class for manipulating images
 */
class ImageHelper {

	/**
	 * Resample the image given as $src and save it to $dst
	 * 
	 * @param $src Filename of the source image
	 * @param $dst Filename of the destination image
	 * @param $width The width of the new image
	 * @param $height The height of the new image
	 * @param $crop Crop factor
	 */
	public static function resample($src, $dst, $width, $height = 0, $crop = 0) {

		if (!list($w, $h) = getimagesize($src))
			return "Unsupported picture type!";

		$type = strtolower(substr(strrchr($src, "."), 1));
		if ($type == 'jpeg')
			$type = 'jpg';
		switch($type) {
			case 'bmp' :
				$img = imagecreatefromwbmp($src);
				break;
			case 'gif' :
				$img = imagecreatefromgif($src);
				break;
			case 'jpg' :
				$img = imagecreatefromjpeg($src);
				break;
			case 'png' :
				$img = imagecreatefrompng($src);
				break;
			default :
				return "Unsupported picture type!";
		}

		// if height = 0 use aspect ratio
		if ($height == 0) {
			$height = round($width * ($h / $w));
		}

		// if height = 0 use aspect ratio
		if ($width == 0) {
			$width = round($height * ($w / $h));
		}

		// resize
		if ($crop) {
			if ($w < $width or $h < $height)
				return "Picture is too small!";
			$ratio = max($width / $w, $height / $h);
			$h = $height / $ratio;
			$x = ($w - $width / $ratio) / 2;
			$w = $width / $ratio;
		} else {
			if ($w < $width and $h < $height)
				return "Picture is too small!";
			$ratio = min($width / $w, $height / $h);
			$width = $w * $ratio;
			$height = $h * $ratio;
			$x = 0;
		}

		$new = imagecreatetruecolor($width, $height);

		// preserve transparency
		if ($type == "gif" or $type == "png") {
			imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
			imagealphablending($new, false);
			imagesavealpha($new, true);
		}

		imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

		switch($type) {
			case 'bmp' :
				imagewbmp($new, $dst);
				break;
			case 'gif' :
				imagegif($new, $dst);
				break;
			case 'jpg' :
				imagejpeg($new, $dst);
				break;
			case 'png' :
				imagepng($new, $dst);
				break;
		}
		return true;
	}

}
