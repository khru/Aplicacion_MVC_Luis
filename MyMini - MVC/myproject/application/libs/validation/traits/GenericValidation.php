<?php
trait GenericValidation
{
	public static function phoneNumber($input)
	{
		$inputName = 'teléfono';
		$minSize = 9;
		$maxSize = 14;
		$regexFunction = 'self::regexPhoneNumber';

		$error = self::basic($input, $inputName, $minSize, $maxSize, $regexFunction);
		
		return self::result($error);
	}// phoneNumber()

	public static function email($input)
	{
		$inputName = 'email';
		$minSize = 7;
		$maxSize = 50;
		$regexFunction = 'self::regexEmail';
		
		$error = self::basic($input, $inputName, $minSize, $maxSize, $regexFunction);

		return self::result($error);
	}// email()

}//trait