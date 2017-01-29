<?php
trait GenericRegex
{
	public static function regexPhoneNumber($input)
	{
 		$pattern = "/^((\\+?34([ \\t|\\-])?)?[9|6|7|8]((\\d{1}([ \\t|\\-])?[0-9]{3})|(\\d{2}([ \\t|\\-])?[0-9]{2}))([ \\t|\\-])?[0-9]{2}([ \\t|\\-])?[0-9]{2})$/";
 		if (preg_match($pattern, $input)) {
 			return true;
 		}
 		return false;
 	}// regexPhoneNumber()

 	public static function regexEmail($input)
 	{
 		if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
 			return true;
 		}
 		return false;
 	}// regexEmail()

} //trait