<?php


class PedidosController extends Zend_Controller_Action {
    
    
     protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		
		
        
    }
        public function indexAction(){
        
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        $this->view->params = $params;
        
        $objPedidos = new Application_Model_DbTable_Pedidos();
        $pedidos = $objPedidos->getPedidos($params);
        $this->view->pedidos = $pedidos;


        $this->view->messages = $this->_flashMessenger->getMessages();

        
    }

    public function cajaAction(){
        
        $params = $this->_getAllParams();
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        $this->view->params = $params;

         $objPago = new Application_Model_DbTable_Pago();

         $objEmpleados = new Application_Model_DbTable_Empleados();

         $this->view->empleados=$objEmpleados->fetchAll();

         $objClientes = new Application_Model_DbTable_Clientes();

         $this->view->clientes=$objClientes->fetchAll();


        
        $objPedidos = new Application_Model_DbTable_Pedidos();
        
          $pedido=$objPedidos->fetchAll('status="1"');

         $this->view->pedido=$pedido;


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

        //var_dump($auth);

         $id = $this->_getParam('id', 0);
        
        //$EstForm = new Application_Form_Estudiantes();
        //$this->view->EstForm = $EstForm;

        $objProductos = new Application_Model_DbTable_Productos();
        // se envia a la vista todos los registros de usuarios

        $objPedidos = new Application_Model_DbTable_Pedidos();
       

         $objClientes = new Application_Model_DbTable_Clientes();
         $cliente= $objClientes->getCliente($id);


        
        if ($id>0) {
            
            //$formData = $this->getRequest()->getPost();
            
                $fecha=time();

                    $hoy=date("Y-m-d", $fecha);

                $data = array(
                    'id_cliente' => $id,
                    'id_user' => $auth->getIdentity()->uid,
                    'total' => 0,
                    'fecha' => $hoy,
                    'status' => '1'
                    
                );

               
                
              
                try {
                 
                  $objPedidos->addPedido($data);

                  $ultimo=$objPedidos->getUltimo();

                  require_once('assets/textveloper/textveloper.api.client.php');

                  $sms = new api();

                    $parameters = array();
                    $parameters['cuenta_token']     = 'TOKEN_CUENTA';
                    $parameters['subcuenta_token']  = 'TOKEN_SUBCUENTA';
                    $parameters['telefono']         = $cliente->tlf;
                    $parameters['mensaje']          = 'Shomi.com ha registrado un pedido para verificarlo ingrese su cedula de identidad y id: '.$ultimo->id;

                    

                    $resp=$sms->enviar($parameters, true);

                    var_dump($sms);





                    // $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                    $this->_redirect('/pedidos/edit/id/'.$ultimo->id);

                } catch (Exception $e) {
                
                $this->_flashMessenger->addMessage(array('success' => 'Ha Ocurrido un Error!'.$e));
                
                $this->_redirect('/pedidos/');

                }

            
            
        }
        
    }

    //editar  estudiantes 
    public function editAction() {


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;  
        
        $id = $this->_getParam('id', 0);

        
          $objProductos = new Application_Model_DbTable_Productos();
        $Productos = $objProductos->getProductos();
        $this->view->productos = $Productos;


         $objDetalle = new Application_Model_DbTable_Detalle();
        $detalles = $objDetalle->getDetallepedido($id);
        $this->view->detalles = $detalles;

        
       // $estForm = new Application_Form_Estudiantes();
       // $this->view->estForm = $estForm;




        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            // se agrega validator para campo username
           
            
            

            

            $id=$formData['id'];

                $data = array(
                    'codigo' => $formData['codigo'],
                    'descripcion' => $formData['descripcion'],
                    'precio' => $formData['precio']
                );
                

                $est = new Application_Model_DbTable_Productos();
                $est->updateProducto($id, $data);

         $this->_flashMessenger->addMessage(array('success' => 'Se ha Editado con éxito! $id'));

                
                $this->_redirect('productos/index');

                        

            
        } else {
            
            if ($id > 0) {
                $objPedidos = new Application_Model_DbTable_Pedidos();
                $res=$objPedidos->getPedido($id);

               // $data=array(
                    $this->view->id=$id;
                    $this->view->did_cliente=$res['id_cliente'];
                    $this->view->dtotal=$res['total'] ;                                    //    );
                //$this->view->data=$data;total
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
                
                $objUsers = new Application_Model_DbTable_Clientes();
                
                
			try {
				$objUsers->deleteCliente($id);
				$mensaje="Se ha Eliminado el Registro Con Éxito";
				
			} catch (Exception $e) {
				$mensaje="No Se Ha Podido Eliminar el Registro. ";
			} 
				
				$this->_flashMessenger->addMessage(array('success' => $mensaje));
					
				  $this->_redirect('clientes/');
				
				
			
                
            } else {
                throw new Exception('No se encontró el registro');
            }
            
        } else {
            $this->_redirect('/clientes');
        }
    }

    //mostart cursos

    public function estadisticaAction(){
        
        
        
        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        
        
        $objPedidos = new Application_Model_DbTable_Pedidos();
  

      
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

            $masVendidos = $objPedidos->masVendidos($fecha_inicio, $fecha_fin);
        
            $this->view->masVendidos = $masVendidos;


             $tipodepago = $objPedidos->tipodepago($fecha_inicio, $fecha_fin);
        
            $this->view->tipodepago = $tipodepago;

             $bestClientes = $objPedidos->bestClientes($fecha_inicio, $fecha_fin);
        
            $this->view->bestClientes = $bestClientes;

        }else{

            $mes=date("m");

            $fin_mes=date("t");

            $ano=date("Y");



            $inicio=$ano."-".$mes."-01";

            $fin=$ano."-".$mes."-".$fin_mes;



            $masVendidos = $objPedidos->masVendidos($inicio, $fin);
        
            $this->view->masVendidos = $masVendidos;

             $tipodepago = $objPedidos->tipodepago($inicio, $fin);
        
            $this->view->tipodepago = $tipodepago;


             $bestClientes = $objPedidos->bestClientes($inicio, $fin);
        
            $this->view->bestClientes = $bestClientes;




        }


        $this->view->messages = $this->_flashMessenger->getMessages();
        
        //$page = $this->_getParam('page', 1);
            
       // $paginator = Zend_Paginator::factory($members);
       // $paginator->setItemCountPerPage(10);
    //$paginator->setCurrentPageNumber($page);

        //$this->view->paginator = $paginator;
        
    }

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

        $objPedidos = new Application_Model_DbTable_Pedidos();
        $pedidos = $objPedidos->getPedidos($params);
        $this->view->pedidos = $pedidos;
        
        $html = $this->view->render('/pedidos/export.phtml');
        
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

        $objPedidos=new Application_Model_DbTable_Pedidos();
        $member=$objPedidos->getPedidoPDF($id); //pdf detail 
        $this->view->mrow=$member;

        $objDetalle=new Application_Model_DbTable_Detalle();
        $detalle_pedido=$objDetalle->getDetallePedido($id); //pdf detail 
        $this->view->detalle_pedido=$detalle_pedido;

        $html=$this->view->render('pedidos/detail.phtml');
        
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

        $pdf->lastPage();
        $pdf->Output('detail_member.pdf', 'I');
        exit();

    }

     public function detalleAction() {

        $this->_helper->layout->disableLayout();
        
        //$id = $this->_getParam('member');
        
        $id = $this->_getParam('id');

        $objPedidos=new Application_Model_DbTable_Pedidos();
        $pedido=$objPedidos->getPedidoPDFun($id); //pdf detail 
        //$this->view->mrow=$member;

        $objDetalle=new Application_Model_DbTable_Detalle();
        $detalle_pedido=$objDetalle->getDetallePedido($id); //pdf detail 
        //$this->view->detalle_pedido=$detalle_pedido;

       

        //$fecha= $detalle_recibo['fecha'];

         $fecha=date('d-m-Y');

        require('assets/fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AddPage();
            //Encabezado 

        $pdf->SetFont('Arial','',12);
        $pdf->Image('assets/img/logo_wake.jpg',10,10,45,24);
        $pdf->Cell(60,12,'', '0');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(80,5,'Horus Wake Boarding', '0',0,'C',false);
        $pdf->Cell(10,5,'', '0');
         $pdf->SetFont('Arial','B',12);
        $pdf->Cell(40,5,'Fecha ', '0',1,'C',false);

         $pdf->SetFont('Arial','',12);
        $pdf->Cell(60,5,'', '0');
        $pdf->Cell(80,5,'Rif.: J-12345678-9', '0',0,'C',false);
        $pdf->Cell(10,5,'', '0');
        $pdf->Cell(40,5,$pedido->fecha, '0',1,'C',false);

        $pdf->Cell(60,5,'', '0');
        $pdf->Cell(80,5,'Circulo Militar de las Delicias', '0',0,'C',false);
        $pdf->Cell(10,5,'', '0');
        $pdf->Cell(40,5,'Fact. Numero:'.$pedido->id, '0',1,'C',false);

        $pdf->Cell(60,5,'', '0');
        $pdf->Cell(80,5,'Telf.: 0243-1234-123', '0',0,'C',false);
        $pdf->Cell(10,5,'', '0');
        $pdf->Cell(40,5,'', '0',1,'C',false);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,5,'', '0');
        $pdf->Cell(80,5,'Factura', '0',1,'C',false);

        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(190,5,'Cliente', '1',1,'C',false);
        
        $pdf->Cell(190,5,'Nombre cliente: '.$pedido->nombre , '1',1,'L',false);
       
        $pdf->Cell(190,5,'Direccion cliente: '.$pedido->direccion , '1',1,'L',false);
        
        $pdf->Cell(95,5,'Cedula de identidad: '.$pedido->cedula , '1',0,'L',false);
         $pdf->Cell(95,5,'Telefono: '.$pedido->tlf , '1',1,'L',false);

        /*$pdf->Cell(50,5,'Cedula: ', 'LTR',0,'L',false);
        $pdf->Cell(60,5,'Sueldo: ', 'LTR',1,'L',false);

        $pdf->SetFont('Arial','',11);
/*
        $pdf->Cell(80,5,$permisos->Nom_emp.' '.$permisos->Ape_emp , 'LRB',0,'L',false);
        $pdf->Cell(50,5,$permisos->Ced_Emp, 'LRB',0,'L',false);
        $pdf->Cell(60,5,$permisos->TrbSld, 'LRB',1,'L',false);

        $pdf->SetFont('Arial','B',11);

        $pdf->Cell(95,5,'Departamento: ', 'LTR',0,'L',false);
        $pdf->Cell(95,5,'Cargo: ', 'LTR',1,'L',false);

        $pdf->SetFont('Arial','',11);

        $pdf->Cell(95,5,$permisos->UbiNom, 'LRB',0,'L',false);
        $pdf->Cell(95,5,$permisos->CrgDsc, 'LRB',1,'L',false);
*/
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('Arial','B',11);

        $pdf->Cell(190,6,'Detalles ', '1',1,'C',false);
        $pdf->Cell(30,6,'Cant: ' , 'LTR',0,'L',false);
        $pdf->Cell(100,6,'Descripcion: ', 'LTR',0,'L',false);
        $pdf->Cell(30,6,'Precio Unit.: ', 'LTR',0,'L',false);
        $pdf->Cell(30,6,'Total: ', 'LTR',1,'L',false);


        $pdf->SetFont('Arial','',11);

        $total_g=0;

        foreach ($detalle_pedido as $detalle) {

        $total_g=$total_g+$detalle->total;

        $pdf->Cell(30,6,$detalle->cantidad , 'LTR',0,'L',false);
        $pdf->Cell(100,6,$detalle->descripcion, 'LTR',0,'L',false);
        $pdf->Cell(30,6,$detalle->precio, 'LTR',0,'L',false);
        $pdf->Cell(30,6,$detalle->total, 'LTR',1,'L',false);
           
        }

        $pdf->Cell(130,6,'', '1',0,'L',false);
        $pdf->Cell(30,6,'Total General', '1',0,'L',false);
        $pdf->Cell(30,6,$total_g, '1',1,'L',false);
/*
        $pdf->Cell(80,5,$permisos->fecha_inicio , 'LRB',0,'L',false);
        $pdf->Cell(50,5,$permisos->fecha_fin, 'LRB',0,'L',false);
        $pdf->Cell(60,5,$permisos->duracion, 'LRB',1,'L',false);

       $pdf->SetFont('Arial','B',11);

        $pdf->Cell(190,5,'Motivo del Persmiso : ', 'LTR',1,'L',false);

        $pdf->SetFont('Arial','',11);

        $pdf->SetFillColor(255,255,255);

        $pdf->MultiCell(190,5,$permisos->motivo, 'LRB',1,'L',true);
*/ 
        $pdf->Ln();
        $pdf->Ln();

 /*       $pdf->SetFont('Arial','B',11);

        $pdf->Cell(190,5,'Para ser llenado por el Supervisor ', '1',1,'C',false);
        $pdf->Cell(80,5,'Nombre y Apellido: ' , 'LTR',0,'L',false);
        $pdf->Cell(60,5,'Cargo: ', 'LTR',0,'L',false);
        $pdf->Cell(50,5,'Firma y Sello de la Unidad: ', 'LTR',1,'L',false);

        $pdf->SetFont('Arial','',11);

        $pdf->Cell(80,5,'' , 'LRB',0,'L',false);
        $pdf->Cell(60,5,'', 'LRB',0,'L',false);
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

        $pdf->Cell(80,5,'Permiso Aprobado?' , 'LRB',0,'L',false);
        $pdf->Cell(30,5,'Si', 'LRB',0,'L',false);
        $pdf->Cell(30,5,'No', 'LRB',0,'L',false);
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

        $pdf->Cell(140,5,'En Caso de Ser negativo Inidque el motivo' , 'LRB',0,'L',false); 
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

        $pdf->Cell(140,20,'' , 'LRB',0,'L',false); 
        $pdf->Cell(50,20,'', 'LR',1,'L',false);

         $pdf->Cell(80,5,'Se adjunta Constancia o Justificativo?' , 'LRB',0,'L',false);
        $pdf->Cell(30,5,'Si', 'LRB',0,'L',false);
        $pdf->Cell(30,5,'No', 'LRB',0,'L',false);
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

         $pdf->Cell(80,5,'se solicita Remuneracion?' , 'LRB',0,'L',false);
        $pdf->Cell(30,5,'Si', 'LRB',0,'L',false);
        $pdf->Cell(30,5,'No', 'LRB',0,'L',false);
        $pdf->Cell(50,5,'', 'LRB',1,'L',false);
       
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(190,5,'Para ser llenado por GTH ', '1',1,'C',false);
        $pdf->Cell(80,5,'Nombre de Analista que recibe: ' , 'LTR',0,'L',false);
        $pdf->Cell(60,5,'Fecha de Recibido: ', 'LTR',0,'L',false);
        $pdf->Cell(50,5,'Firma y Sello de la Unidad: ', 'LTR',1,'L',false);

        $pdf->SetFont('Arial','',11);

        $pdf->Cell(80,5,'' , 'LRB',0,'L',false);
        $pdf->Cell(60,5,'', 'LRB',0,'L',false);
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

        $pdf->Cell(140,5,'Procesado por Nomina:' , 'LRB',0,'L',false);
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

        $pdf->Cell(140,5,'Observaciones' , 'LRB',0,'L',false); 
        $pdf->Cell(50,5,'', 'LR',1,'L',false);

        $pdf->Cell(140,20,'' , 'LRB',0,'L',false); 
        $pdf->Cell(50,20,'', 'LBR',1,'L',false);

         
    */   

     #   $pdf->Cell(190,5,'Va sin Tachaduras ni enmiendas' , '0',0,'C',false); 
       
        $pdf->Output('I', 'guarderia.pdf' );
       
    }


     public function generateCorreo($contenido){

        $cuerpo='
        <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
      <title>Chronikapp.com</title>
      
      <style type="text/css">
         /* Client-specific Styles */
         #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
         body{font-family: "Open Sans", sans-serif; width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/
         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
         a img {border:none;}
         .image_fix {display:block;}
         p {margin: 0px 0px !important;}
         table td {border-collapse: collapse;}
         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
         a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}
         /*STYLES*/
         table[class=full] { width: 100%; clear: both; }
         /*IPAD STYLES*/
         @media only screen and (max-width: 640px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important;
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
         img[class=banner] {width: 440px!important;height:220px!important;}
         img[class=colimg2] {width: 440px!important;height:220px!important;}
         
         
         }
         /*IPHONE STYLES*/
         @media only screen and (max-width: 480px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important; 
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
         img[class=banner] {width: 280px!important;height:140px!important;}
         img[class=colimg2] {width: 280px!important;height:140px!important;}
         td[class=mobile-hide]{display:none!important;}
         td[class="padding-bottom25"]{padding-bottom:25px!important;}
        
         }
      </style>
   </head>
   <body>
<!-- Start of preheader -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10"></td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="100" align="left" border="0" cellpadding="0" cellspacing="0">
                                       <tbody>
                                          <tr>
                                             <td align="left" valign="middle" style="font-family: \'Open Sans\', sans-serif; font-size: 14px;color: #666666" st-content="viewonline" class="mobile-hide">
                                                
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <table width="100" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <tr>
                                             <td width="30" height="30" align="right">
                                                <div class="imgpop">
                                                   <a target="_blank" href="https://facebook.com/shomi">
                                                   <img src="http://localhost/shomi.com.ve/app/assets/img/facebook32.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             
                                             <td width="30" height="30" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="https://twitter.com/shomi">
                                                   <img src="http://localhost/shomi.com.ve/app/assets/img/twitter32.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10"></td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of preheader -->       
<!-- Start of header -->

<!-- End of Header -->
<!-- Start of main-banner -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="banner">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                           <tbody>
                              <tr>
                                 <!-- start of image -->
                                 <td align="center" st-image="banner-image">
                                    <div class="imgpop">
                                       <a target="_blank" href="chronikapp.com"><img  border="0" height="300" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" src="http://chronikapp.com/app/assets/img/LogoChronik.png" class="banner"></a>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <!-- end of image -->
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of main-banner --> 
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="20" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- Start Full Text -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 30px; color: #511487; text-align:center; line-height: 30px;" st-title="fulltext-heading">
                                                Hola '.$contenido['usuario'].'

                                             </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style="font-family: \'Open Sans\', sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                               '.$contenido['texto'].'
                                             </td>
                                          </tr>
                                          <!-- End of content -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                             
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of full text -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- 3 Start of Columns -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <!-- col 1 -->
                                    <table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- image 2 -->
                                          <tr>
                                             <td width="100%" align="center" class="devicewidth">
                                                <img src="http://localhost/shomi.com.ve/app/assets/img/head1.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                          <!-- end of image2 -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->  
                                                <table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                   <tbody>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- title2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #511487; text-align:center; line-height: 24px;" st-title="3col-title1">
                                                            cartuchos de Tinta
                                                         </td>
                                                      </tr>
                                                      <!-- end of title2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- content2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content1">
                                                            Excelente Calidad en la Renegacion de Cartuchos
                                                         </td>
                                                      </tr>
                                                      <!-- end of content2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                     
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- spacing -->
                                    <table width="20" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
                                       <tbody>
                                          <tr>
                                             <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of spacing -->
                                    <!-- col 2 -->
                                    <table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- image 2 -->
                                          <tr>
                                             <td width="100%" align="center" class="devicewidth">
                                                <img src="http://localhost/shomi.com.ve/app/assets/img/head2.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                          <!-- end of image2 -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->  
                                                <table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                   <tbody>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- title2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #511487; text-align:center; line-height: 24px;" st-title="3col-title2">
                                                            Toner
                                                         </td>
                                                      </tr>
                                                      <!-- end of title2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- content2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content2">
                                                           La Mejor Tecnologia en Regeneracion de Tones
                                                         </td>
                                                      </tr>
                                                      <!-- end of content2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- /Spacing -->
                                                     
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- end of col 2 -->
                                    <!-- spacing -->
                                    <table width="1" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
                                       <tbody>
                                          <tr>
                                             <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of spacing -->
                                    <!-- col 3 -->
                                    <table width="186" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- image3 -->
                                          <tr>
                                             <td width="100%" align="center" class="devicewidth">
                                                <img src="http://localhost/shomi.com.ve/app/assets/img/head3.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                          <!-- end of image3 -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->  
                                                <table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                   <tbody>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- title -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 18px; font-weight: 700; color: #511487; text-align:center; line-height: 24px;" st-title="3col-title3">
                                                            Reciclaje
                                                         </td>
                                                      </tr>
                                                      <!-- end of title -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- content -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content3">
                                                            Reciclar es Ganar
                                                         </td>
                                                      </tr>
                                                      <!-- end of content -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                 </td>
                                 <!-- spacing -->
                                 <!-- end of spacing -->
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of 3 Columns -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator --> 
<!-- 2columns -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="2columns">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table bgcolor="#ffffff" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <!-- start of left column -->
                                    <table width="290" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- Spacing -->
                                          <tr>
                                             <td width="100%" height="20"></td>
                                          </tr>
                                          <!-- Spacing -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->
                                                <table width="290" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                                   <tbody>
                                                      <!-- image -->
                                                      <tr>
                                                         <td width="290" height="160" align="center" class="devicewidth">
                                                            <img src="http://localhost/shomi.com.ve/app/assets/img/fullhead1.jpg" alt="" border="0" width="160" height="160" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
                                                         </td>
                                                      </tr>
                                                      <!-- Content -->
                                                      <tr>
                                                         <td>
                                                            <table width="270" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                               <tbody>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #511487; line-height:24px;text-align:center;" st-title="2coltitle1">
                                                                        Suministros Importados
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; line-height:24px; color: #666666; text-align:center;" st-conteent="2colcontent1">
                                                                        En nuestra empresa utilizamos los mejores suministros para garantizar un excelente rendimiento y calidad en su impresion
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                      </tr>
                                                      <!-- end of Content -->
                                                      <!-- end of content -->
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- end of left column -->
                                    <!-- start of right column -->
                                    <table width="290" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- Spacing -->
                                          <tr>
                                             <td width="100%" height="20"></td>
                                          </tr>
                                          <!-- Spacing -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->
                                                <table width="290" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                                   <tbody>
                                                      <!-- image -->
                                                      <tr>
                                                         <td width="290" height="160" align="center" class="devicewidth">
                                                            <img src="http://localhost/shomi.com.ve/app/assets/img/fullhead2.jpg" alt="" border="0" width="160" height="160" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
                                                         </td>
                                                      </tr>
                                                      <!-- Content -->
                                                      <tr>
                                                         <td>
                                                            <table width="270" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                               <tbody>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #511487;line-height:24px; text-align:center;" st-title="2coltitle2">
                                                                        Calidad y Color
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; line-height:24px; color: #666666; text-align:center;" st-content="2colcontent2">
                                                                        Colores vivos y brillantes, es lo mas importante al hacer sus impresiones. En Shomi.com es nuestra prioridad
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                      </tr>
                                                      <!-- end of Content -->
                                                      <!-- end of content -->
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- end of right column -->
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10"></td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of 2 columns -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- Start Full Text -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td  align="center" class="devicewidth">
                                                   <img src="http://localhost/shomi.com.ve/app/assets/img/pie.png" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
                                             </td>

                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                        
                                          <!-- End of spacing -->
                                          <!-- content -->
                                         
                                          <!-- End of content -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                             
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of full text -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td COLSPAN="4" align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td COLSPAN="4" width="550" align="left" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    
                  </tr>
                  <tr >
                  <td style="width: 35%;"></td><td style="width: 35%;"></td>
                     <td align="right" height="50" style="font-size:10px; line-height:1px; text-align: right;">
                           Desarrollado Por: 
                     </td>
                     <td align="center" height="50" style="font-size:12px; line-height:1px; text-align: left;">
                           
                              <a target="_blank" href="http://www.abakusit.com">
                                 <img src="http://localhost/shomi.com.ve/app/assets/img/logo_apaisado.png" alt="" height="20" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
                              </a>                 
                          
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->  

   
   </body>
   </html>';





        return $cuerpo;

     }

}

