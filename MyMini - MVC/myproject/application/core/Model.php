<?php

class Model
{
	protected $conexion;
	
	public function __construct(Database $db)
	{
		$this->conexion = $db->getDatabase();
	}
}