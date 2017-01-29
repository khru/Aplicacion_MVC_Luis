<?php
class Revistas extends Controller{

	public function __construct(View $view, RevistasModel $RevistasModel)
    {
        //Recupero los parámetros recibidos
        $args = func_get_args();

        //Llamo al padre usando los mismos parámetros
        call_user_func_array('parent::__construct', $args);

        Auth::checkSubAutentication();
    }// construct()

    public function index()
    {
        $publicadas = $this->RevistasModel->getAll(1);
        $this->view->render('revistas/seeAll', array('publicadas' => $publicadas));
    }// index()

    public function adminAll()
    {   
        Auth::checkAdminAutentication();
        $publicadas = $this->RevistasModel->getAll(1);
        $noPublicadas = $this->RevistasModel->getAll(0);
        $this->view->render('revistas/adminAll', array('publicadas' => $publicadas, 
            'noPublicadas' => $noPublicadas));
    }// adminAll()

    public function insert()
    {
        Auth::checkAdminAutentication();
        if(!$_POST){
            $this->view->render('revistas/form');
        }else{

            if($this->RevistasModel->insert($_POST, $_FILES)){
                header("Location: /Revistas/adminAll");
                exit();
            }else{
                $this->view->render('revistas/form');
            }
        }
    }// insert()

    public function edit($title)
    {
        Auth::checkAdminAutentication();
        $revista = $this->RevistasModel->getByTitle($title);

        if(!$revista){
            header("Location: /Revistas/adminAll");
            exit();
        }

        if(!$_POST){
            $this->view->render('revistas/form', array('accion' => 'editar', 'revista' => $revista));
        }else{
            if($this->RevistasModel->edit($_POST, $_FILES, $title)){
                header("Location: /Revistas/adminAll");
                exit();
            }else{
                $this->view->render('revistas/form', array('accion' => 'editar', 'revista' => $revista));
            }
        }
    }// edit()

    public function delete($title, $confirm = null)
    {
        Auth::checkAdminAutentication();
        $revista = $this->RevistasModel->getByTitle($title);

        if(!$revista){
            header("Location: /Revistas/adminAll");
            exit();
        }

        if(!$confirm){
            $this->view->render('revistas/form', array('accion' => 'eliminar', 'revista' => $revista));
            
        }else{
            $this->RevistasModel->delete($title);
            header("Location: /Revistas/adminAll");
            exit();
        }

    }// delete()

    public function download($file)
    {
        $publicatedOnly = false;
        if(!Session::userIsAdmin()){
            $publicatedOnly = true;
        }

        $revista = $this->RevistasModel->getByFile($file, $publicatedOnly, 1)->file;
        if(!$revista){
            header("Location: /Revistas/index");
            exit();
        }

        $revista = REV . $revista;
        
        if(!file_exists($revista)){
            Session::add('warning', 'No tenemos la revista especificada');
            header("Location: /Revistas/index");
            exit();
        }

        //Fuerza la descarga sin cambiar de página
        header('Content-Description: File Transfer');
        //Tipo MIME del fichero
        header('Content-type: application/pdf');
        //Nombre del fichero que guardará el cliente
        header('Content-Disposition: attachment; filename="'.basename($revista).'"');
        //Tiempo de expiración
        header('Expires: 0');
        //Cache
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        //Tamaño del fichero
        header('Content-Length: ' . filesize($revista));

        readfile($revista);
        exit();
    }// download()
}