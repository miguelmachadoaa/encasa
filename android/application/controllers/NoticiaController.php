<?php

class NoticiaController extends Zend_Controller_Action {
    
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
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
        $this->view->noticias = $ObjNoticias->getNoticias();
        
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
   
        
    }

    public function tagsAction(){

        $id = $this->_getParam('id');


        
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
            'id_autor' => $auth->getIdentity()->uid,
            'titulo' => $formData['titulo'],
            'noticia' => $formData['noticia'],
            'date_add' => date('Y-m-d'),
            'date_upd' => date('Y-m-d'),
            'estatus' => '1',
            'foto'=>$new_file
            );
                
                $ObjNoticias = new Application_Model_DbTable_Noticias();
                $ObjNoticias->addNoticia($data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/noticia/');
            
            
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
            'noticia' => $formData['noticia'],
            'date_upd' => date('Y-m-d'),
            'estatus' => '1',
            'foto'=>$new_file
            );


        }else{
           

            $data = array(
            'titulo' => $formData['titulo'],
            'noticia' => $formData['noticia'],
            'date_upd' => date('Y-m-d'),
            'estatus' => '1'
            );

        }


        $id=$formData['id'];

           
                $ObjNoticias = new Application_Model_DbTable_Noticias();
                $ObjNoticias->updateNoticia($id, $data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/noticia/');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjNoticias = new Application_Model_DbTable_Noticias();
        
                $this->view->noticia=$ObjNoticias->getNoticia($id);

                $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();

                $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);



            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }

    public function delAction() {
     
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest()->getPost();
            
            if (isset($request['uid']) && $request['uid'] > 0) {
                
                $uid = $request['uid'];
                
                $objUsers = new Application_Model_DbTable_Users();
                
                if ($objUsers->deleteUser($uid)) {
                    
                    $this->_flashMessenger->addMessage(array('success' => 'Se ha eliminado el usuario con éxito!'));
                    $this->_redirect('/users');
                    
                } else {
                    
                    $this->_flashMessenger->addMessage(array('error' => 'Ocurrió un error eliminando el registro, intente nuevamente.'));
                    $this->_redirect('/users');
                    
                }
                
            } else {
                throw new Exception('No se encontró el registro');
            }
            
        } else {
            $this->_redirect('/users');
        }
        
    }


     public function getcantidadAction(){

         $id = $this->_getParam('id', 0);

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
        $noticias=$ObjNoticias->getNoticiasCantidad($id);

        $json = array();

    

        foreach ($noticias as $row) {
           
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
           
        }
        
        echo json_encode($json);  
    }

     public function getallAction(){

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
        $noticias=$ObjNoticias->getNoticias();

        $json = array();

    

        foreach ($noticias as $row) {
           
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
           
        }
        
        echo json_encode($json);  
    }


    public function deleteAction(){

          $id = $this->_getParam('id', 0);

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjNoticias = new Application_Model_DbTable_Noticias();
        // se envia a la vista todos los registros de usuarios
        $noticias=$ObjNoticias->deleteNoticia($id);

        $json = array();

        if ($noticias) {
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







