<?php
trait UserValidation
{
	public static function nick($input)
	{
		$inputName = 'nick';
		$minSize = 3;
		$maxSize = 25;
		$regexFunction = 'self::regexNick';

		$error = self::basic($input, $inputName, $minSize, $maxSize, $regexFunction);
		
		return self::result($error);
	}// nick()

	public static function password($input)
	{
		$inputName = 'contraseña';
		$minSize = 4;
		$maxSize = 25;
		$regexFunction = 'self::regexPassword';

		$error = self::basic($input, $inputName, $minSize, $maxSize, $regexFunction);
		
		return self::result($error);
	}// password()

}//trait