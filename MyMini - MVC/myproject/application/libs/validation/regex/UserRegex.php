<?php
trait UserRegex
{
	public static function regexNick($input, $minSize, $maxSize)
	{
 		$pattern = "/^[^@\\\]{" . $minSize ."," . $maxSize . "}$/";

 		if (preg_match($pattern, $input)) {
 			return true;
 		}
 		return false;
 	}// regexNick()

	public static function regexPassword($input, $minSize, $maxSize)
	{
 		$pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{" . $minSize ."," . $maxSize . "}$/";

 		if (preg_match($pattern, $input)) {
 			return true;
 		}
 		return false;
 	}// regexPassword()

} //trait