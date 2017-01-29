<?php

class NewsModel extends Model
{
	private function createSlug($string)
	{
		$slug = preg_replace('/[^A-Za-z0-9-]+/','-',$string);
    	$slug = strtolower($slug);
    	
    	$exist_slug = true;
    	while($exist_slug){
    		
    		$ssql = "SELECT * FROM noticia WHERE slug = :slug";
			$query = $this->conexion->prepare($ssql);
			$query->bindParam(':slug', $slug);
			$query->execute();
    		if($query->rowCount() == 1){
    			$slug = $slug . "-" . mt_rand(1000, 9000); 
    		}else{
    			$exist_slug = false;
    		}
    	}
    	return $slug;
	}// createSlug()

	public function insert($data)
	{
		if(!$data){
			Session::add('feedback_negative', 'No se han recibido datos');
            return false;
		}

		$fields = ["titulo", "cuerpo", "publicada"];
		$data = CleanUp::secure($data, $fields);

		foreach ($data as $campo) {
            CleanUp::clean($campo);
        }

        if(($error = Validation::newsTitle($data['titulo'])) !== true){
            Session::add('feedback_negative', $error);
        }

        if(($error = Validation::newsBody($data['cuerpo'])) !== true){
            Session::add('feedback_negative', $error);
        }

        if(Session::get('feedback_negative')){
            return false;
        }
        //Aseguro la franja horaria
        date_default_timezone_set('Europe/Madrid');
        $fecha_publicacion =  "0000-00-00 00:00:00";
        $cuerpo = Helpers::nl2br($data["cuerpo"]);
        $slug = $this->createSlug($data["titulo"]);
        $publicada = 0;
        if($data["publicada"] == 'on'){
        	$publicada = 1;
            $fecha_publicacion = date("Y-m-d H:i:s");
        }
        
		$ssql = "INSERT INTO noticia (slug, titulo, cuerpo, fecha_publicacion, publicada)
		VALUES(:slug, :titulo, :cuerpo, :fecha_publicacion, :publicada)";

        $query = $this->conexion->prepare($ssql);
        $query->execute(array(':slug' => $slug, ':titulo' => $data["titulo"], ':cuerpo' => $cuerpo, ':fecha_publicacion' => $fecha_publicacion, ':publicada' => $publicada
        	));

        if($query->rowCount() == 1){
        	Session::add('feedback_positive', 'Noticia insertada correctamente');
        	return true;
        }else{
        	Session::add('warning', 'No se ha podido insertar la noticia');
        	return false;
        }
	}// insert()

    public function edit($data, $slug)
    {
        if(!$data){
            Session::add('feedback_negative', 'No se han recibido datos');
            return false;
        }

        $fields = ["titulo", "cuerpo", "publicada"];
        $data = CleanUp::secure($data, $fields);

        foreach ($data as $campo) {
            CleanUp::clean($campo);
        }

        if(($error = Validation::newsTitle($data['titulo'])) !== true){
            Session::add('feedback_negative', $error);
        }

        if(($error = Validation::newsBody($data['cuerpo'])) !== true){
            Session::add('feedback_negative', $error);
        }

        if(Session::get('feedback_negative')){
            return false;
        }
        //Aseguro la franja horaria
        date_default_timezone_set('Europe/Madrid');
        $fecha_publicacion =  "0000-00-00 00:00:00";
        $cuerpo = Helpers::nl2br($data["cuerpo"]);
        $newSlug = $this->createSlug($data["titulo"]);
        $publicada = 0;
        if($data["publicada"] == 'on'){
            $publicada = 1;
            $fecha_publicacion = date("Y-m-d H:i:s");
        }

        $ssql = "UPDATE noticia SET slug = :newSlug, titulo = :titulo, cuerpo = :cuerpo, fecha_publicacion = :fecha_publicacion, publicada = :publicada WHERE slug = :slug";

        $query = $this->conexion->prepare($ssql);
        $query->execute(array(':newSlug' => $newSlug, ':slug' => $slug, ':titulo' => $data["titulo"], ':cuerpo' => $cuerpo, ':fecha_publicacion' => $fecha_publicacion, ':publicada' => $publicada
            ));

        if($query->rowCount() == 1){
            Session::add('feedback_positive', 'Noticia editada correctamente');
            return true;
        }else{
            Session::add('warning', 'No se ha podido editar la noticia');
            return false;
        }
    }// edit()

    public function delete($slug)
    {
        $ssql = "DELETE FROM noticia WHERE slug = :slug";
        $query = $this->conexion->prepare($ssql);
        $query->bindParam(':slug', $slug);
        $query->execute();
        if($query->rowCount() == 1){
            Session::add('feedback_positive', 'Noticia borrada correctamente');
            return true;
        }else{
            Session::add('warning', 'No se ha podido borrar la noticia');
            return false;
        }
    }// delete()

	public function getBySlug($slug, $publicada = 0)
	{
		$ssql = "SELECT * FROM noticia WHERE slug = :slug";
        if($publicada){
            $ssql .= " AND publicada = 1";
        }
		$query = $this->conexion->prepare($ssql);
		$query->bindParam(':slug', $slug);
		$query->execute();
		if($query->rowCount() == 1){
			return $query->fetch();
		}else{
			Session::add('warning', 'No se ha encontrado esa noticia');
			return false;
		}
	}// getBySlug()

	public function getAll($publicada)
	{
		$ssql = "SELECT * FROM noticia where publicada = :publicada";
		$query = $this->conexion->prepare($ssql);
		$query->bindParam(':publicada', $publicada);
		$query->execute();

		return $query->fetchAll();
	}// getAll()
}// class