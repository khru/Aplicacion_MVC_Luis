<?php
trait NewsValidation
{
	public static function newsTitle($input)
	{
		$inputName = 'título';
		$minSize = 4;
		$maxSize = 100;
		$regexFunction = 'self::regexNewsTitle';

		$error = self::basic($input, $inputName, $minSize, $maxSize, $regexFunction);
		
		return self::result($error);
	}// newsTitle()

	public static function newsBody($input)
	{
		$inputName = 'cuerpo';
		$minSize = 1;
		$maxSize = 2000;
		$regexFunction = 'self::regexNewsBody';

		$error = self::basic($input, $inputName, $minSize, $maxSize, $regexFunction);
		
		return self::result($error);
	}// newsBody()

}//trait