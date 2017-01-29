<?php

class RevistasModel extends Model
{
	public function getAll($publicada)
	{
		$ssql = "SELECT * FROM revista where publicada = :publicada";
		$query = $this->conexion->prepare($ssql);
		$query->bindParam(':publicada', $publicada);
		$query->execute();

		return $query->fetchAll();
	}// getAll()

	public function getByTitle($title, $publicada = 0, $msg = 0, $tituloActual = 0)
	{
		$ssql = "SELECT * FROM revista WHERE titulo = :title";
        if($publicada){
            $ssql .= " AND publicada = 1";
        }
        if($tituloActual){
            $ssql .= " AND titulo != :tituloActual";
        }
		$query = $this->conexion->prepare($ssql);
		$query->bindParam(':title', $title);
        if($tituloActual){
            $query->bindParam(':tituloActual', $tituloActual);
        }
		$query->execute();
		if($query->rowCount() == 1){
			return $query->fetch();
		}else{
			if($msg){
				Session::add('warning', 'No se ha encontrado esa revista');
			}
			return false;
		}
	}// getByFile()

	public function getByFile($file, $publicada = 0, $msg = 0)
	{
		$ssql = "SELECT * FROM revista WHERE file = :file";
        if($publicada){
            $ssql .= " AND publicada = 1";
        }
		$query = $this->conexion->prepare($ssql);
		$query->bindParam(':file', $file);
		$query->execute();
		if($query->rowCount() == 1){
			return $query->fetch();
		}else{
			if($msg){
				Session::add('warning', 'No se ha encontrado esa revista');
			}
			return false;
		}
	}// getByFile()

	public function insert($data, $fileData)
	{
		//No hay datos por post
		if(!$data){
			Session::add('feedback_negative', 'No se han recibido datos');
            return false;
		}
		
		//Se aseguran los datos de post
		$fields = ["titulo", "publicada"];
		$data = CleanUp::secure($data, $fields);

		//Se sanean los datos de post
		foreach ($data as $campo) {
            CleanUp::clean($campo);
        }

        //Se aseguran los datos de files
        $files = ["img", "file"];
        $fileData = CleanUp::secure($fileData, $files);

        //Variables con los ficheros
        $img = $fileData["img"];
        $file = $fileData["file"];

        if($img["error"]){
        	Session::add('feedback_negative', 'No se ha recibido la imagen');
        }

        if($file["error"]){
        	Session::add('feedback_negative', 'No se ha recibido el fichero PDF');
        }

        //Validación del título
        $data["titulo"] = CleanUp::secureUrl($data["titulo"]);

        if(($error = Validation::newsTitle($data['titulo'])) !== true){
            Session::add('feedback_negative', $error);
        }

        if(Session::get('feedback_negative')){
            return false;
        }

        //Se comprueba si ya existe el título
        $existTitle = self::getByTitle($data['titulo'],0,0);
        if($existTitle){
        	Session::add('feedback_negative', 'Ya existe una revista con ese título');
            return false;
        }

        //Saneamiento de nombres
        $img["name"] = CleanUp::secureUrl($img["name"]);
        $file["name"] = CleanUp::secureUrl($file["name"]);

        //Comprueba la existencia de archivos en el servidor y renombra de ser necesario
        $img["name"] = Helpers::reName(PRIV_IMG, $img["name"]);
        $file["name"] = Helpers::reName(REV, $file["name"]);

        //Tamaño maximo de archivo
        $tamMax = 2 * 1024 * 1024;

        //Tamaño de los archivos recibidos
        if($img["size"] == 0){
        	Session::add('feedback_negative', 'No se ha subido correctamente la imagen');
        }

        if($img["size"] > $tamMax){
        	Session::add('feedback_negative', 'La imagen no puede superar los $tamMax bytes');
        }

        if($file["size"] == 0){
        	Session::add('feedback_negative', 'No se ha subido correctamente el fichero PDF');
        }

        if($file["size"] > $tamMax){
        	Session::add('feedback_negative', 'El fichero PDF no puede superar los $tamMax bytes');
        }

        if(Session::get('feedback_negative')){
            return false;
        }

        //Tipo MIME
        if($img["type"] != 'image/jpeg'){
        	Session::add('feedback_negative', 'Sólo se admiten imágenes JPG');
        }

        if($file["type"] != 'application/pdf'){
        	Session::add('feedback_negative', 'Sólo se admiten ficheros PDF');
        }

        if(Session::get('feedback_negative')){
            return false;
        }

        //Se suben los archivos
        $imgDestino = PRIV_IMG . $img["name"];
        if(!move_uploaded_file($img["tmp_name"], $imgDestino)) { 
			Session::add('feedback_negative', 'No se ha podido subir la imagen al servidor'); 
		}

		$fileDestino = REV . $file["name"];
        if(!move_uploaded_file($file["tmp_name"], $fileDestino)) { 
			Session::add('feedback_negative', 'No se ha podido subir el fichero PDF al servidor'); 
		}

		if(Session::get('feedback_negative')){
            return false;
        }
        //Se evalua si se debe publicar o no
        $publicada = 0;
        if($data["publicada"] == 'on'){
        	$publicada = 1;
        }

		$ssql = "INSERT INTO revista (titulo, img, file, publicada)
		VALUES(:titulo, :img, :file, :publicada)";

        $query = $this->conexion->prepare($ssql);
        $query->execute(array(':titulo' => $data["titulo"], ':img' => $img["name"], ':file' => $file["name"], ':publicada' => $publicada
        	));

        //Se realiza la inserción
        if($query->rowCount() == 1){
        	Session::add('feedback_positive', 'Revista insertada correctamente');
        	return true;
        }else{
        	Session::add('warning', 'No se ha podido insertar la revista');
        	return false;
        }
	}// insert()

    public function edit($data, $fileData, $tituloActual)
    {
        //No hay datos por post
        if(!$data){
            Session::add('feedback_negative', 'No se han recibido datos');
            return false;
        }

        $sameImg = null;
        $sameFile = null;
        //Casillas de verificación
        if(isset($data["sameImg"]) && $data["sameImg"] == 'on'){
            $sameImg = $data["sameImg"];
        }
        
        if(isset($data["sameFile"]) && $data["sameFile"] == 'on'){
            $sameFile = $data["sameFile"];
        }
        
        //Se aseguran los datos de post
        $fields = ["titulo", "publicada"];
        $data = CleanUp::secure($data, $fields);

        //Se sanean los datos de post
        foreach ($data as $campo) {
            CleanUp::clean($campo);
        }

        //Validación del título
        $data["titulo"] = CleanUp::secureUrl($data["titulo"]);

        if(($error = Validation::newsTitle($data['titulo'])) !== true){
            Session::add('feedback_negative', $error);
            return false;
        }

         //Se comprueba si ya hay otro registro con ese título
        $existTitle = self::getByTitle($data['titulo'],0,0, $tituloActual);
        if($existTitle){
            Session::add('feedback_negative', 'Ya existe una revista con ese título');
            return false;
        }

        //Tamaño maximo de archivo
        $tamMax = 2 * 1024 * 1024;

        if(!$sameImg){
            $files = ["img"];
            $fileData = CleanUp::secure($fileData, $files);
            
            //Variable con el archivo
            $img = $fileData["img"];

            if($img["error"]){
                Session::add('feedback_negative', 'No se ha recibido la imagen');
                return false;
            }

            //Saneamiento de nombres
            $img["name"] = CleanUp::secureUrl($img["name"]);

            //Comprueba la existencia de archivos en el servidor y renombra de ser necesario
            $img["name"] = Helpers::reName(PRIV_IMG, $img["name"]);

            //Tamaño de los archivos recibidos
            if($img["size"] == 0){
                Session::add('feedback_negative', 'No se ha subido correctamente la imagen');
                return false;
            }

            if($img["size"] > $tamMax){
                Session::add('feedback_negative', 'La imagen no puede superar los $tamMax bytes');
                return false;
            }
            
            //Tipo MIME
            if($img["type"] != 'image/jpeg'){
                Session::add('feedback_negative', 'Sólo se admiten imágenes JPG');
                return false;
            }

            //Se sube el archivo
            $imgDestino = PRIV_IMG . $img["name"];

            if(!move_uploaded_file($img["tmp_name"], $imgDestino)) { 
                Session::add('feedback_negative', 'No se ha podido subir la imagen al servidor'); 
                return false;
            }
        
        }

        if(!$sameFile){
            $files = ["file"];
            $fileData = CleanUp::secure($fileData, $files);

            //Variable con el archivo
            $file = $fileData["file"];

            if($file["error"]){
                Session::add('feedback_negative', 'No se ha recibido el archivo PDF');
                return false;
            }

            //Saneamiento de nombres
            $file["name"] = CleanUp::secureUrl($file["name"]);

            //Comprueba la existencia de archivos en el servidor y renombra de ser necesario
            $file["name"] = Helpers::reName(REV, $file["name"]);

            //Tamaño de los archivos recibidos
            if($file["size"] == 0){
                Session::add('feedback_negative', 'No se ha subido correctamente el fichero PDF');
                return false;
            }

            if($file["size"] > $tamMax){
                Session::add('feedback_negative', 'El fichero PDF no puede superar los $tamMax bytes');
                return false;
            }

            //Tipo MIME
            if($file["type"] != 'application/pdf'){
                Session::add('feedback_negative', 'Sólo se admiten ficheros PDF');
                return false;
            }

            //Se sube el archivo
            $fileDestino = REV . $file["name"];
            if(!move_uploaded_file($file["tmp_name"], $fileDestino)) { 
                Session::add('feedback_negative', 'No se ha podido subir el fichero PDF al servidor');
                return false; 
            }
        }
        //Se evalua si se debe publicar o no
        $publicada = 0;
        if($data["publicada"] == 'on'){
            $publicada = 1;
        }

        //Se prepara y ejecuta la consulta
        $ssql = "UPDATE revista SET ";

        if(!$sameImg){
            $ssql .= "img = :img, ";
        }

        if(!$sameFile){
            $ssql .= "file = :file, ";
        }

        $ssql .= "titulo = :titulo, publicada = :publicada WHERE titulo = :tituloActual";

        $query = $this->conexion->prepare($ssql);
        $query->bindParam(':titulo', $data["titulo"]);
        $query->bindParam(':publicada', $publicada);
        $query->bindParam(':tituloActual', $tituloActual);

        if(!$sameImg){
            $query->bindParam(':img', $img["name"]);
        }
        if(!$sameFile){
            $query->bindParam(':file', $file["name"]);
        }

        $query->execute();

        //Se realiza la inserción
        if($query->rowCount() == 1){
            Session::add('feedback_positive', 'Revista editada correctamente');
            return true;
        }else{
            Session::add('warning', 'No se ha podido editar la revista (o los campos ya tenían esos valores)');
            return false;
        }
    }// edit()

    public function delete($titulo)
    {
        $ssql = "DELETE FROM revista WHERE titulo = :titulo";
        $query = $this->conexion->prepare($ssql);
        $query->bindParam(':titulo', $titulo);
        $query->execute();
        if($query->rowCount() == 1){
            Session::add('feedback_positive', 'Revista borrada correctamente');
            return true;
        }else{
            Session::add('warning', 'No se ha podido borrar la revista');
            return false;
        }
    }// delete()

}// class