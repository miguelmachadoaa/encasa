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


        $fecha_actual = date("Y-m-d h:m:s");


        $inm=$ObjInmueble->fetchAll('estatus="activo"');

        foreach ($inm as $i) {
            
            if ($i->fecha_activo<=$fecha_actual) {

                $u = array('estatus' => 'suspendida');

                $ObjInmueble->upd($i->id, $u);


                # code...
            }

        }

     
        
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







