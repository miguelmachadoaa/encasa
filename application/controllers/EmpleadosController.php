<?php


class EmpleadosController extends Zend_Controller_Action {
    
    
     protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		
		
        
    }
        public function indexAction(){
        
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        
    
        $this->view->params = $params;
        
        $objEmpleados = new Application_Model_DbTable_Empleados();
        $empleados = $objEmpleados->getEmpleados();
        $this->view->empleados = $empleados;

      
        //consulta estado y envio de objeto

        $objStates = new Application_Model_DbTable_States();
        $this->view->objStates = $objStates;
        
        $states = $objStates->fetchAll();
        $this->view->states = $states;


        $this->view->messages = $this->_flashMessenger->getMessages();
        
 
        
    }

    public function entradaAction(){
        
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        $fecha=date('Y-m-d');

        $inicio=$fecha.' 00:00:00';
        $fin=$fecha.' 23:59:59';
    
        $this->view->params = $params;
        
        $objAsistencia = new Application_Model_DbTable_Asistencia();

        $objEmpleados = new Application_Model_DbTable_Empleados();
        $empleados = $objEmpleados->getEmpleados();
        $this->view->empleados = $empleados;


        if ($this->getRequest()->isPost()) {

                $formData = $this->getRequest()->getPost();
            
                $data = array(
                    'id_empleado' => $formData['empleado'],
                   
                    
                );

        $objAsistencia = new Application_Model_DbTable_Asistencia();

        $objAsistencia->add($data);

        }

        $this->view->asistencia=$objAsistencia->getAsistenciaDia($inicio, $fin);



        $this->view->messages = $this->_flashMessenger->getMessages();
        
        
    }

     public function asistenciaAction(){
        
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        /*$fecha=date('Y-m-d');

        $inicio=$fecha.' 00:00:00';
        $fin=$fecha.' 23:59:59';*/
    
        $this->view->params = $params;
        
        $objAsistencia = new Application_Model_DbTable_Asistencia();

       /* $objEmpleados = new Application_Model_DbTable_Empleados();
        $empleados = $objEmpleados->getEmpleados();
        $this->view->empleados = $empleados;*/


        if ($this->getRequest()->isPost()) {

                $formData = $this->getRequest()->getPost();
            
                

            $inicio=$formData['inicio'];

            $fin=$formData['fin'];

           // echo $inicio;

           // echo $fin;

           $pinico = split('/', $inicio);
            $fecha_inicio=$pinico[2].'-'.$pinico[1].'-'.$pinico[0];

            $pfin = split('/', $fin);
            $fecha_fin=$pfin[2].'-'.$pfin[1].'-'.$pfin[0];

            $this->view->inicio=$inicio;
             $this->view->fin=$fin;

            if($fecha_inicio>$fecha_fin){
                $mientras=$fecha_inicio;

                $fecha_inicio=$fecha_fin;

                $fecha_fin=$mientras;
            }

             $fecha_inicio=$fecha_inicio.' 00:00:00';

            $fecha_fin=$fecha_fin.' 23:59:59';

                 $this->view->asistencia=$objAsistencia->getAsistenciaDia($fecha_inicio, $fecha_fin);

        }else{

            $this->view->asistencia=$objAsistencia->getAsistencia();
        }

        



        $this->view->messages = $this->_flashMessenger->getMessages();
        
        
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
            
           
        
            $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_nac']);
            $fecha_nac=$date->format('Y-m-d');

                $data = array(
                    'cedula' => $formData['cedula'],
                    'nombre' => $formData['nombre'],
                    'tlf' => $formData['tlf'],
                    'estado' => $formData['estado'],
                    'direccion' => $formData['direccion'],
                    'fecha_nac' => $fecha_nac,
                    'email' => $formData['email'],
                    
                );

               
                
                $objEmpleados = new Application_Model_DbTable_Empleados();
                try {
                 
                  $objEmpleados->addEmpleado($data);

                  $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/empleados/');

                } catch (Exception $e) {
                
                $this->_flashMessenger->addMessage(array('success' => 'Ha Ocurrido un Error!'.$e));
                
                $this->_redirect('/empleados/add');

                }

                

                
                

            
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

        
      


        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            // se agrega validator para campo username
           
            
            

            $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_nac']);
            $fecha_nac=$date->format('Y-m-d');

            $id=$formData['id'];

                $data = array(
                    'cedula' => $formData['cedula'],
                    'nombre' => $formData['nombre'],
                    'tlf' => $formData['tlf'],
                    'estado' => $formData['estado'],
                    'direccion' => $formData['direccion'],
                    'fecha_nac' => $fecha_nac,
                    'email' => $formData['email']
                );
                

                $objEmpleados = new Application_Model_DbTable_Empleados();
                $objEmpleados->updateEmpleado($id, $data);

         $this->_flashMessenger->addMessage(array('success' => 'Se ha Editado con éxito! $id'));

                
                $this->_redirect('empleados/index');

                        

            
        } else {
            
            if ($id > 0) {
                $objEmpleados = new Application_Model_DbTable_Empleados();
                $res=$objEmpleados->getEmpleado($id);

               // $data=array(
                    $this->view->id=$id;
                    $this->view->dcedula=$res['cedula'];
                    $this->view->dnombre=$res['nombre'] ;
                    $this->view->demail=$res['email'];
                    $this->view->dtlf=$res['tlf'];
                    $this->view->destado=$res['estado'];
                    $this->view->ddireccion=$res['direccion'];
                    $this->view->dfecha_nac=$res['fecha_nac'];
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
                
                $objEmpleados = new Application_Model_DbTable_Empleados();
                
                
                
			try {
				$objEmpleados->deleteEmpleado($id);
				$mensaje="Se ha Eliminado el Registro Con Éxito";
				
			} catch (Exception $e) {
				$mensaje="No Se Ha Podido Eliminar el Registro. ";
			} 
				
				$this->_flashMessenger->addMessage(array('success' => $mensaje));
					
				  $this->_redirect('empleados/');
				
				
			
                
            } else {
                throw new Exception('No se encontró el registro');
            }
            
        } else {
            $this->_redirect('/empleados');
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
        
        $objMembers = new Application_Model_DbTable_Clientes();
        $members = $objMembers->getClientes($params);
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
        
        $html = $this->view->render('/clientes/export.phtml');
        
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

