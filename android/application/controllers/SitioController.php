<?php

class SitioController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

        $Obj= new Application_Model_DbTable_Identidad();
        
                $this->view->identidad=$Obj->get('1');

                
        
    }

    public function listAction(){
        
       $ObjServicios= new Application_Model_DbTable_Servicios();

      
        $this->view->servicios = $ObjServicios->fetchAll();
        
            
        
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        $page = $this->_getParam('page', 1);
            
        $paginator = Zend_Paginator::factory($ObjServicios->fetchAll());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        
    }

    public function indexAction(){



        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


        
            $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');

        
          $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
        $this->view->noticias = $ObjNoticias->Aleatorio();

        $meta = array(
            'titulo' => 'Nosotros -En Casa Plus', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }

    public function verAction(){

        $id = $this->_getParam('empresa', 0);


        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);

         $ObjUsers= new Application_Model_DbTable_Users();

         $this->view->usuario=$ObjUsers->fetchRow('id="'.$id.'"');
      
        $ObjInmueble= new Application_Model_DbTable_Inmueble();
           
        $inm_usuarios = $ObjInmueble->getInmueblesUsuario($id);

        $inm_aliados = $ObjInmueble->getInmueblesNegocio($id);

         //var_dump($inm_usuarios);

        $inmuebles = array();

         foreach ($inm_usuarios as $row ) {

            

             $inmuebles[]=$row;
         }

          foreach ($inm_aliados as $row ) {

            $row->usuario=$id;

             $inmuebles[]=$row;
         }


        $this->view->inmuebles = $inmuebles;

         $meta = array(
            'titulo' => 'En Casa Plus', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;

        
        
    }

     public function inmuebleAction(){

        $empresa = $this->_getParam('empresa', 0);
        $inmueble = $this->_getParam('inmueble', 0);


        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);

        

        $this->view->id=$inmueble;

        $data = array('id_inmueble' =>$inmueble );

        $ObjViews= new Application_Model_DbTable_Views();

        $ObjViews->add($data);
        
       $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $datos_inm=$ObjInmueble->getInmueble($inmueble);

        $datos_inm['usuario']=$empresa;

        $this->view->presupuesto = $datos_inm;
        
        $ObjFotos= new Application_Model_DbTable_Fotos();

        $this->view->fotos=$ObjFotos->gets($inmueble);

    


        
        
    }

  


     private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
        }

     public function addAction(){


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;

          
     
        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            

        $dest_dir = "assets/img/";
            
            /* Uploading Document File on Server */
            $upload = new Zend_File_Transfer_Adapter_Http();
            $upload->setDestination($dest_dir)
                         ->addValidator('Count', false, 1)
                         ->addValidator('Size', false, 1048576)
                         ->addValidator('Extension', false, 'jpg,png,gif');
            $files = $upload->getFileInfo();
            
            // debug mode [start]
            echo '<hr />
                            <pre>';
            print_r($files);
            echo '  </pre>
                        <hr />';
         
               if($upload->receive()) {
        
            
            $mime_type = $upload->getMimeType('doc_path');
            $fname = $upload->getFileName('doc_path');
            $size = $upload->getFileSize('doc_path');
            $file_ext = $this->getFileExtension($fname);            
            $new_file = $dest_dir.md5(mktime()).'.'.$file_ext;
            
            $filterFileRename = new Zend_Filter_File_Rename(
                array(
                    'target' => $new_file, 'overwrite' => true
            ));
            
            $filterFileRename->filter($fname);

            if (file_exists($new_file))
            {
                $request = $this->getRequest();
                $caption = $request->getParam('caption');
                
                $html = 'Orig Filename: '.$fname.'<br />';
                $html .= 'New Filename: '.$new_file.'<br />';
                $html .= 'File Size: '.$size.'<br />';
                $html .= 'Mime Type: '.$mime_type.'<br />';
                $html .= 'Caption: '.$caption.'<br />';
            }
            else
            {
                $html = 'Unable to upload the file!';
            }

        }else{
            $new_file='assets/img/default.jpg';
        }




            $data = array(
            'id' => $formData['id'],
            'titulo' => $formData['titulo'],
            'descripcion' => $formData['descripcion'],
            'estatus' => '1',
            'imagen'=>$new_file
            );
                
        $ObjServicios= new Application_Model_DbTable_Servicios();
                $ObjServicios->add($data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/servicios/list');
                

            
        }
        
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
            $new_file = $dest_dir.md5(mktime()).'.'.$file_ext;
            
            $filterFileRename = new Zend_Filter_File_Rename(
                array(
                    'target' => $new_file, 'overwrite' => true
            ));
            
            $filterFileRename->filter($fname);

            

            $data = array(
            'titulo' => $formData['titulo'],
            'descripcion' => $formData['descripcion'],
            'imagen'=>$new_file
            );







        }else{
           

            $data = array(
            'titulo' => $formData['titulo'],
            'descripcion' => $formData['descripcion'],
            );

        }


        $id=$formData['id'];



           
        $ObjServicios= new Application_Model_DbTable_Servicios();
              
                $ObjServicios->upd($id, $data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/servicios/list');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjServicios= new Application_Model_DbTable_Servicios();
        
                $this->view->servicios=$ObjServicios->get($id);



            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }





     public function getallAction(){

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjModulos = new Application_Model_DbTable_Modulos();
        // se envia a la vista todos los registros de usuarios
        $modulos=$ObjModulos->fetchAll();

        $json = array();

    

        foreach ($modulos as $row) {
           
          

           $json[]=$row->toArray();
           
        }
        
        echo json_encode($json);  
    }


    public function deleteAction(){

          $id = $this->_getParam('id', 0);

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjMarcas = new Application_Model_DbTable_Marcas();
        // se envia a la vista todos los registros de usuarios
        $res=$ObjMarcas->del($id);

        $json = array();

        if ($res) {
           $json[]=array('res' => true );
        }else{
             $json[]=array('res' => false);
        }
        
      
        
        echo json_encode($json);  
    }






}







