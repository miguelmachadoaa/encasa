<?php

class BlogController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

        $auth = Zend_Auth::getInstance();

        if ($auth->getIdentity()) {
            # code...
       

        
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
         

        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');


        Zend_Session::start();
        
        $userDetails = new Zend_Session_Namespace('userDetails');

        if (isset($userDetails->spais)) {
            
                $this->view->spais=$userDetails->spais;

            }else{

                $userDetails->spais = '1';

                $this->view->spais=$userDetails->spais;

            }





        
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

        // se instancia el modelo users
       // $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
       //icias = $ObjNoticias->getNoticias();

         // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
              
        $this->view->etiquetas = $ObjEtiquetas->getEtiquetaGroup();
        

        $related=$ObjNoticias->fetchAll();

        //var_dump($related);

        $this->view->related=$related;

        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();


         $meta = array(
            'titulo' => 'En casa Plus - Noticias', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;


        
    }

         public function verAction(){

             $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();


        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);

        $id = $this->_getParam('id', 1);
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
        $this->view->noticias = $ObjNoticias->getNoticiaId($id);
        $noticias = $ObjNoticias->getNoticiaId($id);

       

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


         $meta = array(
            'titulo' => $noticias['titulo'].' - En casa Plus', 
            'descripcion' => substr($noticias['noticia'], 0,500), 
            'imagen' => 'http://www.encasa.tk/'.$noticias['foto'],
            'url'=>'encasa.tk/blog/ver/id/'.$id
            );

         $this->view->meta=$meta;
        
       
        
    }

        public function tagsAction(){

          $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);

        $id = $this->_getParam('id');

        $this->view->id=$id;


        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
        
       
        $this->view->etiquetas = $ObjEtiquetas->getEtiquetaGroup();

        $data = array();

        
            $data[]=$id;
        

        $related=$ObjNoticias->getNoticiasTags($data);

        //var_dump($related);

        $this->view->related=$related;
        
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();

        
             $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();

        $meta = array(
            'titulo' => 'Etiquetas - En casa Plus', 
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







