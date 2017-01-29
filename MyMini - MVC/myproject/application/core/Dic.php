<?php
//Clase que almacena el contenedor de inyección de dependencias
class Dic
{
	private static $instance = null;
	private $container = null;

	private function __construct()
	{
		$this->container = new \Dice\Dice();
	}

	public static function getInstance()
	{
		if(!isset(self::$instance)){
			self::$instance = new Dic();
		}
		return self::$instance;
	}

	public function getContainer()
	{
		return $this->container;
	}
}