<?php

class UserModel extends Model
{
	public function getUser($user)
	{
		if(strpos($user, '@') !== false){
			$ssql = "SELECT nick, password, email, categoria FROM usuario WHERE email=:user";
		}else{
			$ssql = "SELECT nick, password, email, categoria FROM usuario WHERE nick=:user";
		}

		$query = $this->conexion->prepare($ssql);
		$query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute();

		return $query->fetch();
	}
}// class