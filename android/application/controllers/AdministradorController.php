<?php

class AdministradorController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

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

         $auth = Zend_Auth::getInstance();
        
        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;
        
        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $ObjSolicitud= new Application_Model_DbTable_Solicitud();

        $ObjUsers= new Application_Model_DbTable_Users();

      
        $this->view->inmuebles = $ObjInmueble->getInmueblesLimit(10);

        $this->view->usuario = $ObjUsers->getUsuario($uid);

        $this->view->datos = $ObjInmueble->getInmueblesUsuarioDatos($uid);

        $this->view->mensajes = $ObjInmueble->getInmueblesUsuarioContacto($uid);

        $this->view->solicitudes=$ObjSolicitud->getSolicitudesUsuario($uid);
        
    }

    


        public function perfilAction(){

         $auth = Zend_Auth::getInstance();

        
        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;
        
        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $ObjUsers= new Application_Model_DbTable_Users();


      
        $this->view->inmuebles = $ObjInmueble->getInmueblesUsuario($uid);

        $this->view->usuario = $ObjUsers->getUsuario($uid);

        $this->view->datos = $ObjInmueble->getInmueblesUsuarioDatos($uid);

        $this->view->mensajes = $ObjInmueble->getInmueblesUsuarioContacto($uid);

        //echo $uid;
        
    }

  
     public function verAction(){

     	
     	$file=scandir($this->baseUrl('assets/img/'));

     	var_dump($file);

    }

    public function imagesAction(){

     	
     	$file=scandir('assets/images/');

     	$this->view->images=$file;

     	

    }

     private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
        }



        public function editAction() {
        
        $id = $this->_getParam('id', 0);
        
        

        if ($this->getRequest()->isPost()){
            
            $formData = $this->getRequest()->getPost();
            

        $dest_dir = "assets/img/";
            
            /* Uploading Document File on Server */
            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination($dest_dir)
                         ->addValidator('Count', false, 1)
                         ->addValidator('Size', false, 1048576)
                         ->addValidator('Extension', false, 'jpg,png,gif');
            $files = $upload->getFileInfo();
         
           
               if($upload->receive()) {
          
            
            $mime_type = $upload->getMimeType('doc_path');
            $fname = $upload->getFileName('doc_path');
            $size = $upload->getFileSize('doc_path');
            $file_ext = $this->getFileExtension($fname);            
            $new_file = md5(mktime()).'.'.$file_ext;
            
            $filterFileRename = new Zend_Filter_File_Rename(
                array(
                    'target' => $dest_dir.$new_file, 'overwrite' => true
            ));
            
            $filterFileRename->filter($fname);

            

            $data = array(
            'name' => $formData['name'],
            'lastname' => $formData['lastname'],
            'email' => $formData['email'],
            'telefono' => $formData['telefono'],
            'movil' => $formData['movil'],
            'state_id' => $formData['estado'],
            'imagen'=>$new_file
            );







        }else{
           

            $data = array(
            'name' => $formData['name'],
            'lastname' => $formData['lastname'],
            'email' => $formData['email'],
            'telefono' => $formData['telefono'],
            'movil' => $formData['movil'],
            'state_id' => $formData['estado'],
            );

        }


        $id=$formData['id'];



           
        $ObjUsers= new Application_Model_DbTable_Users();
              
                $ObjUsers->upd($id, $data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/administrador/perfil');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjUsers= new Application_Model_DbTable_Users();
        
                $this->view->elemento=$ObjUsers->fetchRow('id="'.$id.'"');

                 $db_states = new Application_Model_DbTable_States();
                
                $this->view->estados=$db_states->getStates();



            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }



  
}







