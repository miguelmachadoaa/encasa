<?php

class EstadisticaController extends Zend_Controller_Action {
    
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
        
       $id = $this->_getParam('id', 0);

       // $data = array('id_inmueble' =>$id );

        $ObjViews= new Application_Model_DbTable_Views();

        //$ObjViews->add($data);

        $estadistica=$ObjViews->Allestadistica();

        $respuesta = array();
        $labels = '';
        $data = '';
        $datasets=array(
            'label'=>'Vistas',
            'backgroundColor'=> "rgba(38, 185, 154, 0.31)",
            'borderColor'=> "rgba(38, 185, 154, 0.7)",
            'pointBorderColor'=> "rgba(38, 185, 154, 0.7)",
            'pointBackgroundColor'=> "rgba(38, 185, 154, 0.7)",
            'pointHoverBackgroundColor'=> "#fff",
            'pointHoverBorderColor'=> "rgba(220,220,220,1)",
            'pointBorderWidth'=> 1,);

            $i=0;


        foreach ($estadistica as $val) {
            if ($i==0) {
                $labels=$labels.'"'.$val->fecha.'"';
                $data=$data.'"'.$val->cantidad.'"';
                $i++;
            }else{
                $labels=$labels.',"'.$val->fecha.'"';
                $data=$data.',"'.$val->cantidad.'"';
            }

           
        }


        $datasets['data']=$data;
        $respuesta['labels']=$labels;
        $respuesta['datasets']=$datasets;

        $respuesta='{ "labels": ['.$labels.'], "datasets": [{ "label": "Vistas", "backgroundColor": "rgba(38, 185, 154, 0.31)", "borderColor": "rgba(38, 185, 154, 0.7)", "pointBorderColor": "rgba(38, 185, 154, 0.7)", "pointBackgroundColor": "rgba(38, 185, 154, 0.7)", "pointHoverBackgroundColor": "#fff", "pointHoverBorderColor": "rgba(220,220,220,1)", "pointBorderWidth": 1, "data": ['.$data.'] }] }';

        $this->view->estadistica=$respuesta;



        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $inmuebles=$ObjInmueble->getInmuebleUsuario();


         $respuesta = array();
        $labels = '';
        $data = '';
        $datasets=array(
            'label'=>'Registros',
            'backgroundColor'=> "rgba(38, 185, 154, 0.31)",
            );

            $i=0;


        foreach ($inmuebles as $val) {
            if ($i==0) {
                $labels=$labels.'"'.$val->name.'"';
                $data=$data.'"'.$val->cantidad.'"';
                $i++;
            }else{
                $labels=$labels.',"'.$val->name.'"';
                $data=$data.',"'.$val->cantidad.'"';
            }

           
        }

        $datasets=array(
            'label'=>'Registros',
            'backgroundColor'=> "rgba(38, 185, 154, 0.31)",
            );


        $datasets['data']=$data;
        $respuesta['labels']=$labels;
        $respuesta['datasets']=$datasets;

        $respuesta='{ "labels": ['.$labels.'], "datasets": [{ "label": "Registros", "backgroundColor": "rgba(38, 185, 154, 0.31)", "data": ['.$data.'] }] }';

        $this->view->registros=$respuesta;

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







