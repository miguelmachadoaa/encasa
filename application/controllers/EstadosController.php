<?php

class EstadosController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');

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
        
    }

     public function indexAction(){


        $id = $this->_getParam('id', 1);

        $this->view->id_pais=$id;

        $Obj= new Application_Model_DbTable_Estados();

      
        $this->view->elementos = $Obj->fetchAll('id_pais="'.$id.'"');
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
        
    }


    public function listAction(){
        
       $Obj= new Application_Model_DbTable_Estados();

      
        $this->view->elementos = $Obj->fetchAll();
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
    }

  
     public function verAction(){

        $id = $this->_getParam('id', 1);
        
        // se instancia el modelo users
        $ObjModulos= new Application_Model_DbTable_Modulos();

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
        $this->view->noticias = $ObjModulos->fetchAll($id);

        //var_dump($ObjNoticias->getNoticiaId($id))  ;      
       
        $this->view->etiquetas = $ObjEtiquetas->getEtiquetaID($id);

        $tags=$ObjEtiquetas->getEtiquetaID($id);

        $data = array();

        foreach ($tags as $key ) {
            $data[]=$key['descripcion'];
        }

        $related=$ObjNoticias->getNoticiasTags($data);

        $this->view->related=$related; 
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
        
       
        
    }

     private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
        }

     public function addAction(){


         $id = $this->_getParam('id', 1);

        $this->view->id_pais=$id;


        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;
        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            

        unset($formData['controller'],$formData['action'],$formData['module'],$formData['MAX_FILE_SIZE'],$formData['btn_submit']);
         
                
                $ObjEstados= new Application_Model_DbTable_Estados();

                $ObjEstados->add($formData);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/estados/index/id/'.$formData['id_pais']);

            
        }
        
    }

    public function editAction() {
        
        $id = $this->_getParam('id', 0);
        
        

        if ($this->getRequest()->isPost()){
            
            $formData = $this->getRequest()->getPost();
            

        $dest_dir = "assets/img/";

           unset($formData['controller'],$formData['action'],$formData['module'],$formData['MAX_FILE_SIZE'],$formData['btn_submit']);
     

        $id=$formData['id'];
           
        $ObjEstados= new Application_Model_DbTable_Estados();
                
                $ObjEstados->upd($id, $formData);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/estados/');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjEstados= new Application_Model_DbTable_Estados();
        
                $this->view->elemento=$ObjEstados->get($id);



            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }



    public function addciudadAction() {
        
        $id_estado = $this->_getParam('id', 0);

        if ($this->getRequest()->isPost()){
            
        $formData = $this->getRequest()->getPost();
            

           unset($formData['controller'],$formData['action'],$formData['module'],$formData['MAX_FILE_SIZE'],$formData['btn_submit']);
     

           
        $ObjCiudad= new Application_Model_DbTable_Ciudades();
                
                $ObjCiudad->add($formData);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/estados/addciudad/id/'.$formData['id_estado'].'');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id_estado > 0) {

                $ObjCiudad= new Application_Model_DbTable_Ciudades();

                $this->view->elementos=$ObjCiudad->fetchAll('id_estado="'.$id_estado.'"');
                
                
        
                $this->view->id_estado=$id_estado;


                  $ObjEstados= new Application_Model_DbTable_Estados();

                  $this->view->estado=$ObjEstados->get($id_estado);



            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }



     public function addzonaAction() {
        
        $id_ciudad = $this->_getParam('id', 0);
        
        

        if ($this->getRequest()->isPost()){
            
            $formData = $this->getRequest()->getPost();
            

       

           unset($formData['controller'],$formData['action'],$formData['module'],$formData['MAX_FILE_SIZE'],$formData['btn_submit']);
     

        
           
        $ObjZonas= new Application_Model_DbTable_Zonas();
                
                $ObjZonas->add($formData);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/estados/addzona/id/'.$formData['id_ciudad'].'');
            
            // se agrega validator para campo username
            
        } else {
            
            if ($id_ciudad > 0) {
        
                $this->view->id_ciudad=$id_ciudad;

                $ObjZonas= new Application_Model_DbTable_Zonas();

                $this->view->elementos=$ObjZonas->fetchAll('id_ciudad="'.$id_ciudad.'"');

                 $ObjCiudad= new Application_Model_DbTable_Ciudades();

                  $this->view->ciudad=$ObjCiudad->get($id_ciudad);





            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }






     public function getallAction(){

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjProtafolios = new Application_Model_DbTable_Portafolios();
        // se envia a la vista todos los registros de usuarios
        $portafolios=$ObjProtafolios->fetchAll();

        $json = array();

    

        foreach ($portafolios as $row) {
           
          

           $json[]=$row->toArray();
           
        }
        
        echo json_encode($json);  
    }


    public function deleteAction(){

          $id = $this->_getParam('id', 0);

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjPortafolios = new Application_Model_DbTable_Portafolios();
        // se envia a la vista todos los registros de usuarios
        $res=$ObjPortafolios->deletePortafolios($id);

        $json = array();

        if ($res) {
           $json[]=array('res' => true );
        }else{
             $json[]=array('res' => false);
        }
        
      
        
        echo json_encode($json);  
    }






}
