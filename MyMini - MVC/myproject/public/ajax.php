<?php
// DIRECTORY_SEPARATOR adds a slash to the end of the path
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// set a constant that holds the project's "application" folder, like "/var/www/application".
define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);

// Define el directorio de revistas
define('REV', ROOT . 'files/revistas' . DIRECTORY_SEPARATOR);

// This is the (totally optional) auto-loader for Composer-dependencies (to load tools into your project).
// If you have no idea what this means: Don't worry, you don't need it, simply leave it like it is.
if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}

// load application config (error reporting etc.)
require APP . 'config/config.php';

// Define el directorio de imágenes
define('IMG', URL . 'img' . DIRECTORY_SEPARATOR);

require APP . 'config/constructRules.php';

//Sent Data
$data = null;

//Ajax Method
if($_GET){
	$data = $_GET;
}elseif($_POST){
	$data = $_POST;
}
//Creating Ajax object which makes the server response
if($data){
	if(isset($data['function'])){
		$dice = Dic::getInstance()->getContainer();
		$function = $data['function'];
		unset($data['function']);
		$dice->create('Ajax', array('function' => $function, 'data' => $data));
	}else{
		echo "-2";
	}
}else{
	var_dump($_POST);
	echo "-2";
}