<?php

class MarcasController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        
    }

    public function indexAction(){
        
       $ObjMarcas= new Application_Model_DbTable_Marcas();

      
        $this->view->marcas = $ObjMarcas->fetchAll();
        
       
        
        
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        $page = $this->_getParam('page', 1);
            
        $paginator = Zend_Paginator::factory($ObjMarcas->fetchAll());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        
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
                
        $ObjMarcas= new Application_Model_DbTable_Marcas();
                $ObjMarcas->add($data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/marcas/');
                

            
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



           
                $ObjMarcas = new Application_Model_DbTable_Marcas();
                $ObjMarcas->upd($id, $data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/marcas/');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjModulos = new Application_Model_DbTable_Modulos();
        
                $this->view->marcas=$ObjModulos->getModulos($id);



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







