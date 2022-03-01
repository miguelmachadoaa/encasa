<?php

class SlidersController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

        $auth = Zend_Auth::getInstance();

        
        $this->view->auth = $auth;

        $role_id=$auth->getIdentity()->role_id;

        
        $uid=$auth->getIdentity()->uid;
$ObjUsers= new Application_Model_DbTable_Users();
$this->view->usuario = $ObjUsers->getUsuario($uid);

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
        
        // se instancia el modelo users
        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        
      
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        $page = $this->_getParam('page', 1);
            
        $paginator = Zend_Paginator::factory($ObjSliders->fetchAll());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        
    }

  
     public function verAction(){

        $id = $this->_getParam('id', 1);
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
        $this->view->noticias = $ObjNoticias->getNoticiaId($id);

       

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


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;

           $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
     
        
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
            $new_file='0';
        }


            $data = array(
            'id' => $formData['id'],
            'titulo' => $formData['titulo'],

            'descripcion' => $formData['descripcion'],
            'pais' => $formData['pais'],
            'estatus' => '1',
            'imagen'=>$new_file
            );
                
                $ObjSliders = new Application_Model_DbTable_Sliders();
                $ObjSliders->addSliders($data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/sliders/add');
                

            
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
            'pais' => $formData['pais'],
            'imagen'=>$new_file
            );







        }else{
           

            $data = array(
            'titulo' => $formData['titulo'],
            'descripcion' => $formData['descripcion'],
            'pais' => $formData['pais'],
            );

        }


        $id=$formData['id'];



           
                $ObjSliders= new Application_Model_DbTable_Sliders();
                $ObjSliders->updateSliders($id, $data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/sliders/');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjSliders= new Application_Model_DbTable_Sliders();
        
                $this->view->sliders=$ObjSliders->getSliders($id);



            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }






     public function getallAction(){

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $sliders=$ObjSliders->fetchAll();

        $json = array();

    

        foreach ($sliders as $row) {
           
          

           $json[]=$row->toArray();
           
        }
        
        echo json_encode($json);  
    }


    public function deleteAction(){

          $id = $this->_getParam('id', 0);

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $Obj= new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $res=$Obj->deleteSliders($id);

        $json = array();

        if ($res) {
           $json[]=array('res' => true );
        }else{
             $json[]=array('res' => false);
        }
        
      
        
        echo json_encode($json);  
    }


      public function getnoticiaidAction(){

        $id = $this->_getParam('id', 0);

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
        $noticias=$ObjNoticias->getNoticiaId($id);

        $json = array();

        $json[]=$noticias->toArray();

    

        /*foreach ($noticias as $row) {
           
           $fila = array(
            'id' => $row->id,
            'id_autor' => $row->id_autor,
            'nombre' => $row->name,
            'apellido' => $row->lastname,
            'titulo' => $row->titulo,
            'noticia' => strip_tags(substr($row->noticia, 0, 200)),
            'date_add' => $row->date_add,
            'date_upd' => $row->date_upd,
            'estatus' => $row->estatus, 
            'foto' => $row->foto
            );

           $json[]=$fila;
           
        }*/
        
        echo json_encode($json);  
    }


         public function gettagsAction(){

        $idNoticia = $this->_getParam('code');

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjEtiquetas= new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
        $tags=$ObjEtiquetas->getEtiquetasIdNoticia($idNoticia);

        $json = array();

    

        foreach ($tags as $row) {
           
           $fila = array(
            'id' => $row->id,
            'descripcion' => $row->descripcion
            );

           $json[]=$fila;
           
        }
        
        echo json_encode($json);  
    }

     public function setnoticiaAction(){

         $this->_helper->layout('layout')->disableLayout();

         $auth = Zend_Auth::getInstance();

         var_dump($auth);



         $titulo = $this->_getParam('titulo');

         $noticia = $this->_getParam('noticia');
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
       
           
           $data = array(
            'id_autor' => $auth->getIdentity()->uid,
            'titulo' => $titulo,
            'noticia' => $noticia,
            'date_add' => date('Y-m-d'),
            'date_upd' => date('Y-m-d'),
            'estatus' => '1'
            );

           $res=$ObjNoticias->addNoticia($data);

           if ($res) {
               echo TRUE;
           }else{
            echo false;
           }

        
          
    }


    public function settagsAction(){

         $this->_helper->layout('layout')->disableLayout();

         $auth = Zend_Auth::getInstance();

         //var_dump($auth);



         $idNoticia = $this->_getParam('idNoticia');

         $tags = $this->_getParam('tags');
        
        // se instancia el modelo users
        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
       
        
        $tags=explode(',', $tags);

        foreach ($tags as $tag) {
            
             $data = array(
            'id_noticia' => $idNoticia,
            'descripcion' => trim($tag),
            'estatus' => '1'
            );

           $res=$ObjEtiquetas->addEtiqueta($data);

        }


           if ($res) {
               echo TRUE;
           }else{
            echo false;
           }

        
          
    }




}







