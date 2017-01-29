<?php
class News extends Controller{

	public function __construct(View $view, NewsModel $NewsModel)
    {
        //Recupero los parámetros recibidos
        $args = func_get_args();

        //Llamo al padre usando los mismos parámetros
        call_user_func_array('parent::__construct', $args);
    }// construct()

    public function index()
    {
        $publicadas = $this->NewsModel->getAll(1);
        $this->view->render('news/seeAll', array('publicadas' => $publicadas));
    }// index()

    public function adminAll()
    {   
        Auth::checkAdminAutentication();
        $publicadas = $this->NewsModel->getAll(1);
        $noPublicadas = $this->NewsModel->getAll(0);
        $this->view->render('news/adminAll', array('publicadas' => $publicadas, 
            'noPublicadas' => $noPublicadas));
    }// adminAll()

    public function seeOne($slug)
    {
        $publicatedOnly = false;
        if(!Session::userIsAdmin()){
            $publicatedOnly = true;
        }

    	$noticia = $this->NewsModel->getBySlug($slug, $publicatedOnly);

    	if(!$noticia){
    		header("Location: /News/index");
    		exit();
    	}

    	$this->view->render('news/seeOne', array('noticia' => $noticia));
    }// seeOne()

    public function insert()
    {
        Auth::checkAdminAutentication();
    	if(!$_POST){
    		$this->view->render('news/form');
    	}else{
    		if($this->NewsModel->insert($_POST)){
    			header("Location: /News/adminAll");
    			exit();
    		}else{
    			$this->view->render('news/form');
    		}
    	}
    }// insert()

    public function edit($slug)
    {
        Auth::checkAdminAutentication();
        $noticia = $this->NewsModel->getBySlug($slug);

        if(!$noticia){
            header("Location: /News/adminAll");
            exit();
        }

        if(!$_POST){
            $this->view->render('news/form', array('accion' => 'editar', 'noticia' => $noticia));
        }else{
            if($this->NewsModel->edit($_POST, $slug)){
                header("Location: /News/adminAll");
                exit();
            }else{
                $this->view->render('news/form', array('accion' => 'editar', 'noticia' => $noticia));
            }
        }
    }// edit()

    public function delete($slug, $confirm = null)
    {
        Auth::checkAdminAutentication();
        $noticia = $this->NewsModel->getBySlug($slug);

        if(!$noticia){
            header("Location: /News/adminAll");
            exit();
        }

        if(!$confirm){
            $this->view->render('news/form', array('accion' => 'eliminar', 'noticia' => $noticia));
            
        }else{
            $this->NewsModel->delete($slug);
            header("Location: /News/adminAll");
            exit();
        }

    }// delete()
}// class