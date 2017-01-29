<?php
trait NewsRegex
{
	public static function regexNewsTitle($input, $minSize, $maxSize)
	{
 		$pattern = "/^.{" . $minSize ."," . $maxSize . "}$/";
 		if (preg_match($pattern, $input)) {
 			return true;
 		}
 		return false;
 	}// regexNewsTitle()

 	public static function regexNewsBody($input, $minSize, $maxSize)
 	{
 		$pattern = "//";
 		if (preg_match($pattern, $input)) {
 			return true;
 		}
 		return false;
 	}// regexNewsBody()

} //trait