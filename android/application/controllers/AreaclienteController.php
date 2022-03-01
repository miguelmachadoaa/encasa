<?php

class AreaclienteController extends Zend_Controller_Action {
    
    
    public function init() {

        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);
   
        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');

        $auth = Zend_Auth::getInstance();


        if ($auth->hasIdentity()){}else{


            $this->_redirect('/login');
        }

    }
    
    public function indexAction() {

    	$ObjSliders = new Application_Model_DbTable_Sliders();

        // se envia a la vista todos los registros de usuarios

        $this->view->sliders = $ObjSliders->fetchAll();

        $ObjPaginas = new Application_Model_DbTable_Paginas();

        // se envia a la vista todos los registros de usuarios

        $this->view->nosotros = $ObjPaginas->fetchRow('grupo="nosotros"');

        $this->view->atencion = $ObjPaginas->fetchRow('grupo="atencion"');

        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $this->view->inmueble = $ObjInmueble->getInmueblesLimitVisible('8');

        $this->view->destacados = $ObjInmueble->getInmueblesLimitDestacado();

        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->servicios = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');

        $objStates = new Application_Model_DbTable_Estados();
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $objMunicipios = new Application_Model_DbTable_Municipios();
        $municipios = $objMunicipios->fetchAll();
        $this->view->municipios = $municipios;


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



    public function postsolicitudAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;

        $ObjConsultas = new Application_Model_DbTable_Consultas();

        $formData = $this->getRequest()->getPost();
                
                $data = array(
                    'departamento' => $formData['departamento'],
                    'ciudad' => $formData['ciudad'],
                    'zona' => $formData['zona'],
                    'desde' => $formData['desde'],
                    'hasta' => $formData['hasta'],
                    'tipo' => $formData['tipo'],
                    'habitaciones' => $formData['habitaciones'],
                    'banos' => $formData['banos'],
                    'tipo' => $formData['tipo'],
                    'notas' => $formData['notas'],
                    'id_user' => $uid
                );
                
                $ObjConsultas = new Application_Model_DbTable_Consultas();

                $consulta=$ObjConsultas->add($data);

                $this->_redirect('/areacliente/missolicitudes');

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
