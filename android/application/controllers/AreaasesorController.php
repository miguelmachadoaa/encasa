<?php

class AreaasesorController extends Zend_Controller_Action {
    
    
    public function init() {

        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);
   
        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');

    }
    
    public function indexAction() {


         $auth = Zend_Auth::getInstance();

        
        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;


    	
        $ObjInmueble= new Application_Model_DbTable_Inmueble();


        $ObjUsers= new Application_Model_DbTable_Users();



        $this->view->inmueble = $ObjInmueble->getInmueblesLimitVisible('8');

        $this->view->destacados = $ObjInmueble->getInmueblesLimitDestacado();



        $this->view->inmuebles = $ObjInmueble->getInmueblesUsuario($uid);

        $inmuebles = $ObjInmueble->getInmueblesUsuario($uid);

        //$alquiler = $ObjInmueble->getInmueblesUsuario($uid);

        $total=0;

        $vendidas=0;

        $activas=0;

        $suspendidas=0;

        foreach ($inmuebles as $i) {
            $total=$total+1;
            
            if ($i->estatus=='activo') {
               
               $activas=$activas+1;

            }

            if ($i->estatus=='vendida') {
               
               $vendidas=$vendidas+1;

            }

            if ($i->estatus=='suspendida') {
               
               $suspendidas=$suspendidas+1;

            }

        }

        if ($total>0) {
            
        $p_activas=($activas/$total)*100;
        $p_vendidas=($vendidas/$total)*100;
        $p_suspendidas=($suspendidas/$total)*100;

        }else{

                $p_activas=0;
        $p_vendidas=0;
        $p_suspendidas=0;

        }


        $this->view->p_activas=$p_activas;
        $this->view->p_vendidas=$p_vendidas;
        $this->view->p_suspendidas=$p_suspendidas;

        $this->view->total=$total;
        $this->view->vendidas=$vendidas;
        $this->view->activas=$activas;
        $this->view->suspendidas=$suspendidas;

        $this->view->usuario = $ObjUsers->getUsuario($uid);

        $this->view->datos = $ObjInmueble->getInmueblesUsuarioDatos($uid);

        $this->view->mensajes = $ObjInmueble->getInmueblesUsuarioContacto($uid);





         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


    public function solicitudAction() {

        $ObjConsultas = new Application_Model_DbTable_Consultas();

         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


    




    public function mensajesAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;

       $ObjContacto= new Application_Model_DbTable_Contacto();

    $this->view->contactos = $ObjContacto->getContactos();


         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }



    public function datosAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;




    $ObjMarcas= new Application_Model_DbTable_Datos();

      
        $this->view->datos = $ObjMarcas->getDatos();


         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


     public function crmAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;


        $ObjUsers = new Application_Model_DbTable_Users();

        $usuarios=$ObjUsers->fetchAll('role_id="5"');

        $this->view->usuarios=$usuarios;



        $ObjMarcas= new Application_Model_DbTable_Datos();

      
        $this->view->datos = $ObjMarcas->getDatos();


         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


     public function agentesAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;


        $ObjUsers = new Application_Model_DbTable_Users();

        $usuarios=$ObjUsers->fetchAll('role_id!="5"');

        $this->view->usuarios=$usuarios;



        $ObjMarcas= new Application_Model_DbTable_Datos();

      
        $this->view->datos = $ObjMarcas->getDatos();


         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }



 public function solicitudesAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;

        $ObjConsultas = new Application_Model_DbTable_Consultas();

        $this->view->consultas=$ObjConsultas->fetchAll();

         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


public function noticiasAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;

        $ObjNoticias = new Application_Model_DbTable_Noticias();

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
              
        $this->view->etiquetas = $ObjEtiquetas->getEtiquetaGroup();
        

        $related=$ObjNoticias->fetchAll();

        //var_dump($related);

        $this->view->related=$related;

         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }





    public function missolicitudesAction() {

         $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;

        echo $uid;

        $ObjConsultas = new Application_Model_DbTable_Consultas();

        $this->view->consultas=$ObjConsultas->fetchAll('id_user="'.$uid.'"');

         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;

    }


     private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
        }


     public function addAction(){

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $role_id=$auth->getIdentity()->role_id;

        $ObjAccess = new Application_Model_DbTable_Access();

        $controles=$ObjAccess->getAccessControl($role_id);

        $acceso = array();

        $menu=array();

        foreach ($controles as $control) {

            $acceso[$control->resource][$control->privilege]=true;

            $menu[$control->resource][1]=true;
            $menu[$control->resource][$control->privilege]=true;

        }
      
        $this->view->acceso = $acceso;

        $this->view->menu = $menu;

        $objStates = new Application_Model_DbTable_Estados();
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $this->view->uid=$auth->getIdentity()->uid;
        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();

            unset($formData['btn_submit']);

            unset($formData['MAX_FILE_SIZE']);

            $ObjInmueble = new Application_Model_DbTable_Inmueble();
            
            $ObjInmueble->add($formData);

            $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
            
            $this->_redirect('/inmueble/');           
        }
        
    }


    public function buscarAction() {

        
    }


    public function mispropiedadesAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;


        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $this->view->inmueble = $ObjInmueble->getInmueblesUsuario($uid);

        
    }


}
