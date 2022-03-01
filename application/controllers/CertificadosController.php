<?php
class CertificadosController extends Zend_Controller_Action
{
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        
    }

    public function indexAction()
    {
         $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        if ($auth->getIdentity()->role != 'administrador') {
            $params['f_state'] = $auth->getIdentity()->state;
        }
        
        $this->view->params = $params;
        
        $objMembers = new Application_Model_DbTable_Asignado();
        $members = $objMembers->listAsignado($params);
        $this->view->members = $members;

        //se cconsultan los certificados que estan venccidos y que aun siguen vigentes 

        $ven=$objMembers->vencidos();

        if($ven){
            
			foreach ($ven as $key) {
                
				$data = array(
                    'status' => '2'
                );
                $id=$key->id;
                $objMembers->updateAsignado($id, $data);
            }
        }else{
                echo "no se encontraron registros para actualziar";
            }





      
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


        $objCursos = new Application_Model_DbTable_Cursos();
        $this->view->objCursos = $objCursos;
        
        $cursos = $objCursos->fetchAll();
        $this->view->curso = $cursos;

        //consulta de grado y evio de objeto y datos a la vista 
        
        $objgrado = new Application_Model_DbTable_Grado();
        $this->view->objgrado = $objgrado;
        
        $grado = $objgrado->getGrado();
        $this->view->grado = $grado;


        
        $this->view->messages = $this->_flashMessenger->getMessages();
        
       // $page = $this->_getParam('page', 1);
            
     //   $paginator = Zend_Paginator::factory($members);
      //  $paginator->setItemCountPerPage(10);
      //  $paginator->setCurrentPageNumber($page);

      //  $this->view->paginator = $paginator;
    }

      public function addAction(){

        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        //se instancai una clase de la tabla estudiantes 
         $est = new Application_Model_DbTable_Estudiantes();

        $objCities = new Application_Model_DbTable_Cursos();
        $this->view->objCities = $objCities;
        
        $cities = $objCities->fetchAll();
        $this->view->cursos = $cities;
    
        $asgForm = new Application_Form_Asignado();
        $this->view->asgForm = $asgForm;
        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            if ($asgForm->isValid($formData)) {

                $cn=$est->getMemberCedula($formData['estudiante']);

                $id=$cn['id'];



                //tomamos las fechas en formato d-m-Y y lo llevamos a Y-m-d

        $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_cap']);
        $fecha_cap=$date->format('Y-m-d');

        $date2 = DateTime::createFromFormat('d/m/Y', $formData['fecha_ven']);
        $fecha_ven=$date2->format('Y-m-d');

                $data = array(
                    'id_estudiante' => $id,
                    'id_curso' => $formData['curso'],
					'codigo' => $formData['codigo'],
                    'fecha_cap' => $fecha_cap,
                    'fecha_ven' => $fecha_ven
                );
                
                $asg = new Application_Model_DbTable_Asignado();
                $asg->addasignado($data);

    $this->_flashMessenger->addMessage(array('success' => 'Se ha Agregado el Registro con éxito!'));
                
                $this->_redirect('/certificados/index');
                
            } else {
                $CursosForm->populate($formData);
            }
            
        }
        
    }

    //editar los ertifiados 

    public function editAction() {


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;  
        
        $id = $this->_getParam('id', 0);
         $est = new Application_Model_DbTable_Estudiantes();


        $asgForm = new Application_Form_Asignado();
        $this->view->asgForm = $asgForm;

        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            
            if ($asgForm->isValid($formData)) {

                $cn=$est->getMemberCedula($formData['estudiante']);

                $id=$cn['id'];



       $date = DateTime::createFromFormat('d/m/Y', $formData['fecha_cap']);
        $fecha_cap=$date->format('Y-m-d');

        $date2 = DateTime::createFromFormat('d/m/Y', $formData['fecha_ven']);
        $fecha_ven=$date2->format('Y-m-d');

                 $data = array(
                    'id_estudiante' => $id,
                    'id_curso' => $formData['curso'],
					'codigo' => $formData['codigo'],
                    'fecha_cap' => $fecha_cap,
                    'fecha_ven' => $fecha_ven
                );
                
                

                $asg = new Application_Model_DbTable_Asignado();
                $asg->updateAsignado($id, $data);
    $this->_flashMessenger->addMessage(array('success' => 'Se ha Editado el Registro  con éxito!'));
                
                $this->_redirect('/certificados/index');
                
            } else {

                $asgForm->populate($formData);
                
            }
            
        } else {
            
            if ($id > 0) {
                $asg = new Application_Model_DbTable_Asignado();

                    $res=$asg->getAsignadoEdit($id);

                    foreach ($res as  $ren) {

                        $rs=$est->getEstudiante($ren['estudiante']);

                        $cd=$rs['cedula'];

                        //proceso para obtener la cedula mediante el id pendiente
                        $data = array(
					 "codigo" =>$ren['codigo'],
                    "estudiante" => $cd,
                    "curso" =>$ren['curso'],
                    "fecha_cap" =>$ren['fecha_cap'],
                    "fecha_ven" =>$ren['fecha_ven']
                    ); 
                    }
                  //  var_dump($res);
    

                $asgForm->populate($data);
            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }


        public function exportAction() {

        $this->_helper->layout->disableLayout();
        
        $params = $this->_getAllParams();
        $this->view->params = $params;
        
        $objMembers = new Application_Model_DbTable_Asignado();
        $members = $objMembers->listAsignado($params);
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
        
        $objCursos = new Application_Model_DbTable_Cursos();
        $this->view->objCursos = $objCursos;
        
        $cursos = $objCursos->fetchAll();
        $this->view->curso = $cursos;
        
        $html = $this->view->render('certificados/export.phtml');
        
        require_once('assets/tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
        $pdf->Output('export_certificados.pdf', 'I');

        exit();
    }


     public function detailAction() {

        $this->_helper->layout->disableLayout();
        
        //$id = $this->_getParam('member');
        
        $id = $this->_getParam('id');

        $objMembers=new Application_Model_DbTable_Estudiantes();
        $member=$objMembers->getMemberId($id); //pdf detail 
        $this->view->ObjMembers=$objMembers;



        $ObjAsignado=new Application_Model_DbTable_Asignado();
        $asignado=$ObjAsignado->getAsignadoUn($id); //pdf detail 
        $this->view->asignado=$asignado;


        
        $html=$this->view->render('certificados/detail.phtml');
        
        require_once('assets/tcpdf/mypdf.php');
        
        $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


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
        $pdf->lastPage();
        $pdf->Output('detail_certificado.pdf', 'I');
        exit();
    }

    public function verAction() {

        $this->_helper->layout->disableLayout();
        
        //$id = $this->_getParam('member');
        
        $id = $this->_getParam('id');

        $objMembers=new Application_Model_DbTable_Estudiantes();
        $member=$objMembers->getMemberId($id); //pdf detail 
        $this->view->ObjMembers=$objMembers;



        $ObjAsignado=new Application_Model_DbTable_Asignado();
        $asignado=$ObjAsignado->getAsignadoUn($id); //pdf detail 
        $this->view->asignado=$asignado;


        
        $html=$this->view->render('certificados/detail.phtml');
        
        require_once('assets/tcpdf/mypdf.php');
        
        $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


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
        $pdf->lastPage();
        $pdf->Output('detail_certificado.pdf', 'I');
        exit();
    }

     public function deleteAction() {

                    if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest()->getPost();
            
            if (isset($request['id']) && $request['id'] > 0) {
                
                $id = $request['id'];
                
                $objUsers = new Application_Model_DbTable_Asignado();
                
                if ($objUsers->deleteAsignado($id)) {

 $this->_flashMessenger->addMessage(array('success' => 'Se ha Eliminado el Registro con éxito!'));

            
                    $this->_redirect('certificados/index');
                    
                } else {      

$this->_flashMessenger->addMessage(array('success' => 'No se Ha podido Eliminar el Registro!'));             
                    $this->_redirect('certificados/index');
                    
                }
                
            } else {
                throw new Exception('No se encontró el registro');
            }
            
        } else {
            $this->_redirect('/');
        }
    }


}

