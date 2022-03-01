<?php


class EstudiantesController extends Zend_Controller_Action {
    
    
     protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		
		
        
    }
        public function indexAction(){
        
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        if ($auth->getIdentity()->role != 'administrador') {
            $params['f_state'] = $auth->getIdentity()->state;
        }
        
        $this->view->params = $params;
        
        $objMembers = new Application_Model_DbTable_Estudiantes();
        $members = $objMembers->getMembers($params);
        $this->view->members = $members;

      
        //consulta estado y envio de objeto

        $objStates = new Application_Model_DbTable_States();
        $this->view->objStates = $objStates;
        
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $objProfession = new Application_Model_DbTable_Professions();
        $this->view->objProfession = $objProfession;
        
        $professions = $objProfession->fetchAll();
        $this->view->professions = $professions;

        //consulta estado y envio de objeto

        $objCities = new Application_Model_DbTable_Cities();
        $this->view->objCities = $objCities;
        
        $cities = $objCities->fetchAll();
        $this->view->cities = $cities;

        //consulta de grado y evio de objeto y datos a la vista 
        
        $objgrado = new Application_Model_DbTable_Grado();
        $this->view->objgrado = $objgrado;
        
        $grado = $objgrado->fetchAll();
        $this->view->grado = $grado;


        
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        //$page = $this->_getParam('page', 1);
            
       // $paginator = Zend_Paginator::factory($members);
       // $paginator->setItemCountPerPage(10);
	//$paginator->setCurrentPageNumber($page);

        //$this->view->paginator = $paginator;
        
    }

        //mostrar   estudiantes 


    //agregar  estudiantes 

    private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
        }

     public function addAction(){


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        //$EstForm = new Application_Form_Estudiantes();
        //$this->view->EstForm = $EstForm;

        $est = new Application_Model_DbTable_Estudiantes();
        // se envia a la vista todos los registros de usuarios

        $objStates = new Application_Model_DbTable_States();
        $this->view->objStates = $objStates;
        
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $objProfession = new Application_Model_DbTable_Professions();
        $this->view->objProfession = $objProfession;
        
        $professions = $objProfession->fetchAll();
        $this->view->professions = $professions;

        //consulta estado y envio de objeto

        $objCities = new Application_Model_DbTable_Cities();
        $this->view->objCities = $objCities;
        
        $cities = $objCities->fetchAll();
        $this->view->cities = $cities;

        //consulta de grado y evio de objeto y datos a la vista 
        
        $objgrado = new Application_Model_DbTable_Grado();
        $this->view->objgrado = $objgrado;
        
        $grado = $objgrado->fetchAll();
        $this->view->grado = $grado;



        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
           

                 //empieeza subida dde la foto 


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
            // debug mode [end]
            
            //try 
            //{
                // upload received file(s)
               if($upload->receive()) {
           // } 
           // catch (Zend_File_Transfer_Exception $e) 
           // {
           //     $e->getMessage();
           //     exit;
           // }
            
        //if(!$upload->getMimeType('doc_path')){
            
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

            //hasta aqui la subida de la foto 
        
            $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_nac']);
            $fecha_nac=$date->format('Y-m-d');

                $data = array(
                    'cedula' => $formData['cedula'],
                    'nombre' => $formData['nombre'],
                    'apellido' => $formData['apellido'],
                    'tlf' => $formData['tlf'],
                    'grado' => $formData['grado'],
                    'profesion' => $formData['profesion'],
                    'estado' => $formData['estado'],
                    'ciudad' => $formData['ciudad'],
                    'direccion' => $formData['direccion'],
                    'fecha_nac' => $fecha_nac,
                    'email' => $formData['email'],
                    'foto'=>$new_file
                    
                );
                
                $est = new Application_Model_DbTable_Estudiantes();
                $est->addEstudiante($data);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/estudiantes/');
                

            
        }
        
    }

    //editar  estudiantes 
    public function editAction() {


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;  
        
        $id = $this->_getParam('id', 0);

        $objStates = new Application_Model_DbTable_States();
        $this->view->objStates = $objStates;
        
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $objProfession = new Application_Model_DbTable_Professions();
        $this->view->objProfession = $objProfession;
        
        $professions = $objProfession->fetchAll();
        $this->view->professions = $professions;

        //consulta estado y envio de objeto

        $objCities = new Application_Model_DbTable_Cities();
        $this->view->objCities = $objCities;
        
        $cities = $objCities->fetchAll();
        $this->view->cities = $cities;

        //consulta de grado y evio de objeto y datos a la vista 
        
        $objgrado = new Application_Model_DbTable_Grado();
        $this->view->objgrado = $objgrado;
        
        $grado = $objgrado->fetchAll();
        $this->view->grado = $grado;

        
       // $estForm = new Application_Form_Estudiantes();
       // $this->view->estForm = $estForm;




        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            // se agrega validator para campo username
           
            


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
            // debug mode [end]
            
            //try 
            //{
                // upload received file(s)
               if($upload->receive()) {
           // } 
           // catch (Zend_File_Transfer_Exception $e) 
           // {
           //     $e->getMessage();
           //     exit;
           // }
            
        //if(!$upload->getMimeType('doc_path')){
            
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

            $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_nac']);
            $fecha_nac=$date->format('Y-m-d');

            $id=$formData['id'];

                $data = array(
                    'cedula' => $formData['cedula'],
                    'nombre' => $formData['nombre'],
                    'apellido' => $formData['apellido'],
                    'tlf' => $formData['tlf'],
                    'grado' => $formData['grado'],
                    'profesion' => $formData['profesion'],
                    'estado' => $formData['estado'],
                    'ciudad' => $formData['ciudad'],
                    'direccion' => $formData['direccion'],
                    'fecha_nac' => $fecha_nac,
                    'email' => $formData['email'],
                    'foto' => $new_file
                );
                

                $est = new Application_Model_DbTable_Estudiantes();
                $est->updateEstudiante($id, $data);

         $this->_flashMessenger->addMessage(array('success' => 'Se ha Editado con éxito! $id'));

                
                $this->_redirect('estudiantes/index');

        }else{
            $new_file=$formData['doc_path'];
        



            $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_nac']);
            $fecha_nac=$date->format('Y-m-d');

             $id=$formData['id'];

                $data = array(
                    'cedula' => $formData['cedula'],
                    'nombre' => $formData['nombre'],
                    'apellido' => $formData['apellido'],
                    'tlf' => $formData['tlf'],
                    'grado' => $formData['grado'],
                    'profesion' => $formData['profesion'],
                    'estado' => $formData['estado'],
                    'ciudad' => $formData['ciudad'],
                    'direccion' => $formData['direccion'],
                    'fecha_nac' => $fecha_nac,
                    'email' => $formData['email']
                    //'foto' => $new_file
                );
                

                $est = new Application_Model_DbTable_Estudiantes();
                $est->updateEstudiante($id, $data);

         $this->_flashMessenger->addMessage(array('success' => 'Se ha Editado con éxito ! '));

                
                $this->_redirect('estudiantes/index');
            }
                

            
        } else {
            
            if ($id > 0) {
                $est = new Application_Model_DbTable_Estudiantes();
                $res=$est->getEstudiante($id);

               // $data=array(
                    $this->view->id=$id;
                    $this->view->dcedula=$res['cedula'];
                    $this->view->dnombre=$res['nombre'] ;
                    $this->view->dapellido=$res['apellido'];
                    $this->view->demail=$res['email'];
                    $this->view->dtlf=$res['tlf'];
                    $this->view->dgrado=$res['grado'];
                    $this->view->dprofesion=$res['profesion'];
                    $this->view->destado=$res['estado'];
                    $this->view->dciudad=$res['ciudad'];
                    $this->view->ddireccion=$res['direccion'];
                    $this->view->dfecha_nac=$res['fecha_nac'];
                    $this->view->dfoto=$res['foto'];
                //    );
                //$this->view->data=$data;
            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }

    //eliminar  estudiantes 

        public function deleteAction() {

                    if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest()->getPost();
            
            if (isset($request['id']) && $request['id'] > 0) {
                
                $id = $request['id'];
                
                $objUsers = new Application_Model_DbTable_Estudiantes();
                
                
			try {
				$objUsers->deleteEstudiante($id);
				$mensaje="Se ha Eliminado el Registro Con Éxito";
				
			} catch (Exception $e) {
				$mensaje="No Se Ha Podido Eliminar el Registro. ";
			} 
				
				$this->_flashMessenger->addMessage(array('success' => $mensaje));
					
				  $this->_redirect('estudiantes/');
				
				
				
				/*if ($objUsers->deleteEstudiante($id)) {

				$this->_flashMessenger->addMessage(array('success' => 'Se ha Eliminado el Registro con éxito!'));

                $this->_redirect('estudiantes/');
                    
                } else {      

					$this->_flashMessenger->addMessage(array('success' => 'No se Ha podido Eliminar el Registro!'));             
                    $this->_redirect('estudiantes/index');
                    
                }*/
                
            } else {
                throw new Exception('No se encontró el registro');
            }
            
        } else {
            $this->_redirect('/');
        }
    }

    //mostart cursos



//listado de asignados 

 



    /*nuevo Consulta Estudiantes 
    ----------------------------- 
    para probar las funciones 
    que ya estan hehas aqui 

    -----------------------------
    -----------------------------
    -----------------------------
    */



    //export a pdf de los miembros

    public function exportAction() {

        $this->_helper->layout->disableLayout();
        
        $params = $this->_getAllParams();
        $this->view->params = $params;
        
        $objMembers = new Application_Model_DbTable_Estudiantes();
        $members = $objMembers->getMembers($params);
        $this->view->members = $members;

      
        //consulta estado y envio de objeto

        $objStates = new Application_Model_DbTable_States();
        $this->view->objStates = $objStates;
        
       $objProfession = new Application_Model_DbTable_Professions();
        $this->view->objProfession = $objProfession;

        //consulta estado y envio de objeto

        $objCities = new Application_Model_DbTable_Cities();
        $this->view->objCities = $objCities;
        
      

        //consulta de grado y evio de objeto y datos a la vista 
        
        $objgrado = new Application_Model_DbTable_Grado();
        $this->view->objgrado = $objgrado;
        
        $grado = $objgrado->fetchAll();
        $this->view->grado = $grado;
        
        $html = $this->view->render('/estudiantes/export.phtml');
        
        require_once('assets/tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Heureka');
        $pdf->SetTitle('Reporte');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // add a page
        $pdf->AddPage();
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        $pdf->Output('export_members.pdf', 'I');

        exit();
    }


     public function detailAction() {

        $this->_helper->layout->disableLayout();
        
        //$id = $this->_getParam('member');
        
        $id = $this->_getParam('id');

        $objMembers=new Application_Model_DbTable_Estudiantes();
        $member=$objMembers->getMemberId($id); //pdf detail 
        $this->view->mrow=$member;

        foreach ($member as $mem) {
            $foto=$mem->foto;
                $len=strlen("$foto")-3;
                $ext=substr($foto,$len,3);
        }



        $ObjAsignado=new Application_Model_DbTable_Asignado();
        $asignado=$ObjAsignado->getAsignadoUser($id); //pdf detail 
        $this->view->asignado=$asignado;


        
        $html=$this->view->render('estudiantes/detail.phtml');
        
        require_once('assets/tcpdf/tcpdf.php');

        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Heureka');
        $pdf->SetTitle('Detalles de Registro');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

$pdf->Image($foto, 160, 45, 30, 40, $ext, '', '', true, 150, '', false, false, 1, false, false, false);

        $pdf->lastPage();
        $pdf->Output('detail_member.pdf', 'I');
        exit();
    }

}

