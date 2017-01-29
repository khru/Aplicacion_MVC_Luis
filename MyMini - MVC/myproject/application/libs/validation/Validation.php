<?php
class Validation
{
	//Traits
	use GenericValidation;
	use UserValidation;
	use NewsValidation;

	//Regex
	use GenericRegex;
	use UserRegex;
	use NewsRegex;

	/* HELPERS ================================================================*/
	private static function result($error)
	{
		if (!$error) {
			return true;
		}
		return $error;
	}// result()

	private static function basic($input, $inputName, $minSize, $maxSize, $regexFunction)
	{
		$error = null;

		if (!isset($input) || empty($input) || mb_strlen(trim($input)) == 0) {
			$error = "El campo $inputName está vacio";
		} elseif (mb_strlen(trim($input)) < $minSize) {
			$error = "El campo $inputName es demasiado corto";
		} elseif (mb_strlen(trim($input)) > $maxSize) {
			$error = "El campo $inputName es demasiado largo";
		} elseif (!call_user_func($regexFunction, $input, $minSize, $maxSize)) {
			$error = "El campo $inputName no es válido";
		}

		return $error;
	}// basic()

}//class