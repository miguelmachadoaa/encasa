<?php
class CursosController extends Zend_Controller_Action {
    
    
     protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        
    }
    
    public function indexAction() {
         
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        if ($auth->getIdentity()->role != 'administrador') {
            $params['f_state'] = $auth->getIdentity()->state;
        }
        
        $this->view->params = $params;
        
        $objMembers = new Application_Model_DbTable_Cursos();
        $cursos = $objMembers->fetchAll();
        $this->view->cursos = $cursos;

      
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
        
        $grado = $objgrado->getGrado();
        $this->view->grado = $grado;


        
        $this->view->messages = $this->_flashMessenger->getMessages();
        
       // $page = $this->_getParam('page', 1);
       // $paginator = Zend_Paginator::factory($cursos);
       // $paginator->setItemCountPerPage(10);
       // $paginator->setCurrentPageNumber($page);
      // $this->view->paginator = $paginator;
    }

     public function addAction(){

        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        $CursosForm = new Application_Form_Cursos();
        $this->view->CursosForm = $CursosForm;
        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            if ($CursosForm->isValid($formData)) {

                $data = array(
                    'codigo' => $formData['codigo'],
                    'descripcion' => $formData['descripcion'],
                    'duracion' => $formData['duracion']
                 );
                
                $Cursos = new Application_Model_DbTable_Cursos();
                $Cursos->addCurso($data);

        $this->_flashMessenger->addMessage(array('success' => 'Se ha Agregado el Registro con éxito!'));
                
                $this->_redirect('/cursos/index');
                
            } else {
                $EstForm->populate($formData);
            }
            
        }
        
    }


    public function editAction() {
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;  
        
        $id = $this->_getParam('id', 0);
        
        $cursosForm = new Application_Form_Cursos();
        $this->view->cursosForm = $cursosForm;

        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            
            if ($cursosForm->isValid($formData)) {

                $data = array(
                    'codigo' => $formData['codigo'],
                    'descripcion' => $formData['descripcion'],
                    'duracion' => $formData['duracion']
                    );
                
                

                $curso = new Application_Model_DbTable_Cursos();
                $curso->updateCurso($id, $data);

    $this->_flashMessenger->addMessage(array('success' => 'Se ha Editado el Registro con éxito!'));
                
                $this->_redirect('/cursos/index');
                
            } else {

                $cursosForm->populate($formData);
                
            }
            
        } else {
            
            if ($id > 0) {
                $cursos = new Application_Model_DbTable_Cursos();

                $res=$cursos->getCurso($id);

                $data = array(
                    "codigo" => $res['codigo'],
                    "descripcion" =>$res['descripcion'] ,
                    "duracion" =>$res['duracion']
                );
              $cursosForm->populate($data);
            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }

    //eliminar cursos

 public function deleteAction() {

    if ($this->getRequest()->isPost()) {
            
        $request = $this->getRequest()->getPost();
            
			if (isset($request['id']) && $request['id'] > 0) {
                
            $id = $request['id'];
                
            $objUsers = new Application_Model_DbTable_Cursos();
               
			
			
			try {
				$objUsers->deleteCurso($id);
				$mensaje="Se ha Eliminado el Registro Con Éxito";
				
				
			} catch (Exception $e) {
				$mensaje="No se Ha Podido eliminar el Registro. ";
			} 
				
				$this->_flashMessenger->addMessage(array('success' => $mensaje));
					
				$this->_redirect('/cursos/index');
				
			
			

			
			
			
			
			
					
               
            } else {
                throw new Exception('No se encontró el registro');
            }
            
    } else {
            $this->_redirect('/cursos/index');
        }
}

     public function exportAction() {

        $this->_helper->layout->disableLayout();
        

        
        $objMembers = new Application_Model_DbTable_Cursos();
        $cursos = $objMembers->fetchAll();
        $this->view->cursos = $cursos;

      
    
    
        
        $html = $this->view->render('cursos/export.phtml');
        
        require_once('assets/tcpdf/tcpdf.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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

}
