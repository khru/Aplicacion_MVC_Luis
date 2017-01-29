<?php
//Sistema de Dependencias (se crea de nuevo con el fin de desacoplar el código)
$dice = Dic::getInstance()->getContainer();

//=============Reglas de construcción de objetos
  
//Reglas del constructor League\Plates\Engine
$rule = ['constructParams' => ['directory' => APP . 'view']];
$dice->addRule('League\Plates\Engine', $rule);

//Reglas del constructor Error
$rule = ['constructParams' => ['msg' => "La página solicitada no existe"]];
$dice->addRule('Error', $rule);

//Reglas del constructor PDO
$pdo_options = array(
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

$dsn = DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
$rule = ['constructParams' => ['dsn' => $dsn,'username' => DB_USER, 'password' => DB_PASS, 
'options' => $pdo_options]];
$dice->addRule('PDO', $rule);

//Reglas del constructor Database
$rule = ['shared' => true];
$dice->addRule('Database', $rule);

