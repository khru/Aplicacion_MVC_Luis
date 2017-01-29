<?php
class Ajax
{
	private $conexion;

	public function __construct($function, $data, Database $db, UserModel $UserModel)
	{
		$this->conexion = $db->getDatabase();
		$this->UserModel = $UserModel;
		call_user_func("self::$function", $data);
		
	}

	public function checkLogin($data)
	{	
		$user = $data["usuario"];

		if(empty($user)){
			echo "-1";
		}else{
			if(strpos($user, '@') !== false){
		        if($this->UserModel->getUser($user)){
		        	echo 0;
		        }else{
		        	echo 1;
		        }
			}else{
				if($this->UserModel->getUser($user)){
		        	echo 0;
		        }else{
		        	echo 2;
		        }
			}
		}
	}// checkLogin

}// class