<?php

class InmuebleController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');

        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');

        $auth = Zend_Auth::getInstance();

        
        $this->view->auth = $auth;

        /*$uid=$auth->getIdentity()->uid;

$ObjUsers= new Application_Model_DbTable_Users();

$this->view->usuario = $ObjUsers->getUsuario($uid);*/


Zend_Session::start();
        
        $userDetails = new Zend_Session_Namespace('userDetails');

        if (isset($userDetails->spais)) {
            
                $this->view->spais=$userDetails->spais;

            }else{

                $userDetails->spais = '1';

                $this->view->spais=$userDetails->spais;

            }

        
    }

    public function indexAction(){

        $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $userDetails = new Zend_Session_Namespace('userDetails');

        $spais=$userDetails->spais;

        $role_id=$auth->getIdentity()->role_id;
        $uid=$auth->getIdentity()->uid;

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
        
       $ObjInmueble= new Application_Model_DbTable_Inmueble();

            $ObjUsers= new Application_Model_DbTable_Users();

            $this->view->users=$ObjUsers->fetchAll();
      
        $this->view->inmuebles = $ObjInmueble->getInmueblesView();


        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll('pais="'.$spais.'"');

        
    }




    public function aliadosAction(){

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


        $auth = Zend_Auth::getInstance();
        
        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;

        $this->view->uid=$uid;
        
        $ObjInmueble= new Application_Model_DbTable_Inmueble();
        
        $this->view->inmuebles = $ObjInmueble->getInmueblesAliados($uid);
        
    }

        public function datosAction(){

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




        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
  

        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

        $data = array('id_inmueble' =>$id );

        $ObjDatos= new Application_Model_DbTable_Datos();

        $this->view->datos = $ObjDatos->fetchAll('id_inmueble="'.$id.'"');
        
      $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $this->view->inmueble = $ObjInmueble->getInmueble($id);
        
      
   
        
    }

     public function contactoAction(){

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




        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;


        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

        $data = array('id_inmueble' =>$id );

        $ObjContacto= new Application_Model_DbTable_Contacto();

        $this->view->contactos = $ObjContacto->fetchAll('id_inmueble="'.$id.'"');
        
       $ObjInmueble= new Application_Model_DbTable_Inmueble();


        $this->view->inmueble = $ObjInmueble->getInmueble($id);

    }
    public function buscarAction(){

        $params = $this->_getAllParams();

        $this->view->params = $params;

        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;

        $userDetails = new Zend_Session_Namespace('userDetails');

        $spais=$userDetails->spais;


          $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll('pais="'.$spais.'"');


        

        $opt=array('layout'=>'layout');

         Zend_Layout::startMvc($opt);

        $objStates = new Application_Model_DbTable_Estados();
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $ObjPaginas = new Application_Model_DbTable_Paginas();
        // se envia a la vista todos los registros de usuarios
        $this->view->pagina = $ObjPaginas->fetchRow('grupo="inmueble"');

        $objMunicipios = new Application_Model_DbTable_Municipios();


        if (isset($params['f_estado']) ) {

            $estado=$params['f_estado'];
            $municipios = $objMunicipios->fetchAll('estado_id="'.$estado.'"');

            //echo 'paso estado';

        }else{

            $municipios = $objMunicipios->fetchAll();
        }


        
        $this->view->municipios = $municipios;

       

       $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $this->view->inmueble = $ObjInmueble->getInmuebles($params);


        $meta = array(
            'titulo' => 'Busqueda', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


    public function verAction(){



        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        //$this->view->uid=$auth->getIdentity()->uid;
        //$this->view->name=$auth->getIdentity()->name;
       // $this->view->lastname=$auth->getIdentity()->lastname;

        $opt=array('layout'=>'layout');

         Zend_Layout::startMvc($opt);

        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

        $data = array('id_inmueble' =>$id );

        $ObjViews= new Application_Model_DbTable_Views();

        $ObjViews->add($data);
        
       $ObjInmueble= new Application_Model_DbTable_Inmueble();

       $inmueble=$ObjInmueble->getInmueble($id);


        $ObjPaginas = new Application_Model_DbTable_Paginas();
        // se envia a la vista todos los registros de usuarios
        $this->view->pagina = $ObjPaginas->fetchRow('grupo="inmueble"');

      
        $this->view->presupuesto = $inmueble;
        
        $ObjFotos= new Application_Model_DbTable_Fotos();

        $this->view->fotos=$ObjFotos->gets($id);

        $foto=$ObjFotos->fetchRow('id_solicitud="'.$id.'"');



        $meta = array(
            'titulo' => $inmueble['titulo'], 
            'descripcion' => $inmueble['descripcion'], 
            'imagen' => 'http://www.encasa.tk/assets/images/'.$foto->foto,
            'url'=>'encasa.tk/inmueble/ver/id'.$id
            );

         $this->view->meta=$meta;

        
   
        
    }


     public function estadisticaAction(){

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



        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

       // $data = array('id_inmueble' =>$id );

        $ObjViews= new Application_Model_DbTable_Views();

        //$ObjViews->add($data);

        $estadistica=$ObjViews->estadisticaId($id);

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

        $respuesta='{"labels": ['.$labels.'], "datasets": [{ "label": "Vistas", "backgroundColor": "rgba(38, 185, 154, 0.31)", "borderColor": "rgba(38, 185, 154, 0.7)", "pointBorderColor": "rgba(38, 185, 154, 0.7)", "pointBackgroundColor": "rgba(38, 185, 154, 0.7)", "pointHoverBackgroundColor": "#fff", "pointHoverBorderColor": "rgba(220,220,220,1)", "pointBorderWidth": 1, "data": ['.$data.'] }] }';

        $this->view->estadistica=$respuesta;
        
       $ObjInmueble= new Application_Model_DbTable_Inmueble();
      
        $this->view->presupuesto = $ObjInmueble->get($id);
        
        $ObjFotos= new Application_Model_DbTable_Fotos();

        $this->view->fotos=$ObjFotos->gets($id);
        
        
    }

    public function listAction(){

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





        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


        
        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');
        
    }

  


     private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
        }



     public function addAction(){

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

         $objPais = new Application_Model_DbTable_Pais();

        $paises = $objPais->fetchAll();

        $this->view->paises = $paises;





        $objStates = new Application_Model_DbTable_Estados();

        $states = $objStates->fetchAll();

        $this->view->states = $states;


        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        $this->view->uid=$auth->getIdentity()->uid;
        
     
        
        if ($this->getRequest()->isPost()) {
            
                $formData = $this->getRequest()->getPost();

                $fecha_actual = date("d-m-Y");
//sumo 1 día
$fecha_activo= date("Y-m-d h:m:s",strtotime($fecha_actual."+ 90 days")); 

                $formData['fecha_activo']=$fecha_activo;

                //var_dump($formData);

                //die;

                unset($formData['balcon']);
                unset($formData['btn_submit']);
                unset($formData['pais']);

                unset($formData['MAX_FILE_SIZE']);

                $ObjInmueble = new Application_Model_DbTable_Inmueble();
                
                $ObjInmueble->add($formData);

                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/inmueble/');           
        }
        
    }

    public function editAction() {

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


        
        $id = $this->_getParam('id', 0);

        $objPais = new Application_Model_DbTable_Pais();

        $paises = $objPais->fetchAll();

        $this->view->paises = $paises;

        $objStates = new Application_Model_DbTable_Estados();
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $objCities = new Application_Model_DbTable_Cities();
        $cities = $objCities->fetchAll();
        $this->view->cities = $cities;


        if ($this->getRequest()->isPost()){
            
            $formData = $this->getRequest()->getPost();
            
            $id=$formData['id'];

            unset($formData['pais']);
            unset($formData['btn_submit']);

            unset($formData['MAX_FILE_SIZE']);

            $ObjInmueble = new Application_Model_DbTable_Inmueble();
                
            $ObjInmueble->upd($id, $formData);
           
                $this->_flashMessenger->addMessage(array('success' => 'Se ha Actualizado con éxito!'));
                
                $this->_redirect('/inmueble/');
            
            // se agrega validator para campo username
            
            
            
        } else {
            
            if ($id > 0) {
                
                $ObjInmueble = new Application_Model_DbTable_Inmueble();

                $inmueble=$ObjInmueble->getInmueble($id);


        
                $this->view->inmueble=$inmueble;




                




                $ObjFotos= new Application_Model_DbTable_Fotos();

                $this->view->fotos=$ObjFotos->gets($id);





        $objStates = new Application_Model_DbTable_Estados();
        $states = $objStates->fetchAll();
        $this->view->states = $states;
        
        $objCities = new Application_Model_DbTable_Ciudades();
        $cities = $objCities->fetchAll('id_estado="'.$inmueble->id_estado.'"');
        $this->view->cities = $cities;

        $objZonas = new Application_Model_DbTable_Zonas();
        $zonas = $objZonas->fetchAll('id_ciudad="'.$inmueble->id_ciudad.'"');
        $this->view->zonas = $zonas;

        




            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }




public function detalleAction() {

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

        

        $this->_helper->layout->disableLayout();
        
        //$id = $this->_getParam('member');
        
        $id = $this->_getParam('id');

        $auth = Zend_Auth::getInstance();
        
        $this->view->auth = $auth;

        $uid=$auth->getIdentity()->uid;



        //$id_permiso=base64_decode($code);

        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $ObjUsers= new Application_Model_DbTable_Users();

        $ObjFotos = new Application_Model_DbTable_Fotos();

        $foto=$ObjFotos->getsSolicitudUna($id);

        $inmueble=$ObjInmueble->getInmueble($id);

        $usuario=$ObjUsers->fetchRow('id="'.$uid.'"');

              
        //$fecha= $detalle_recibo['fecha'];

         //$fecha=date('d-m-Y');

        require('assets/fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial','',12);
        $pdf->Image('assets/img/EnCasaPlus.png',10,10,50,20);
        $pdf->SetFont('Arial','B',12);
            //Encabezado 

        $pdf->SetFont('Arial','',12);
        $pdf->Image('assets/images/'.$foto->foto,10,50,90,90);
        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,5,'', '0',0,'L',false);
        $pdf->Cell(100,5,'Datos de Contacto del Asesor', '0',1,'L',false);

        $pdf->SetFont('Arial','',10);

        
        $pdf->Cell(80,5,'', '0',0,'L',false);
        $pdf->Cell(100,5,utf8_decode($usuario['name'].' '.$usuario['lastname']), '0',1,'L',false);
        
        $pdf->Cell(80,5,'', '0',0,'L',false);
        $pdf->Cell(100,5,utf8_decode($usuario['email']), '0',1,'L',false);

        $pdf->Cell(80,5,'', '0',0,'L',false);
        $pdf->Cell(100,5,utf8_decode($usuario['telefono']), '0',1,'L',false);

        $pdf->Cell(80,5,'', '0',0,'L',false);
        $pdf->Cell(100,5,utf8_decode($usuario['movil']), '0',1,'L',false);
        $pdf->Cell(100,5,'', '0',1,'L',false);

        $pdf->SetFont('Arial','B',12);
        
        


        $pdf->Cell(200,5,utf8_decode($inmueble['titulo']), '0',1,'L',false);
        $pdf->Cell(100,5,'', '0',1,'L',false);
        $pdf->Cell(100,5,'', '0',0,'L',false);
        
         $pdf->SetFont('Arial','B',12);
        $pdf->Cell(50,5,'Detalles Del Inmueble', '0',1,'L',false);
         $pdf->SetFont('Arial','',10);
        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Codigo: '.$inmueble['id'], '0',1,'L',false);
        
        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Ubicacion: '.$inmueble['estado'], '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Ciudad: '.$inmueble['ciudad'], '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Zona: '.$inmueble['zona'], '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Tipo: '.$inmueble['tipo_inmueble'], '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,utf8_decode('Edad: '.$inmueble['edad_inmueble']), '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Habitaciones: '.$inmueble['habitaciones'], '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,utf8_decode('Baños: '.$inmueble['banos']), '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Puestos Estacionamiento: '.$inmueble['puestos'], '0',1,'L',false);


        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Area Construccion: '.$inmueble['contruccion'], '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Area total: '.$inmueble['totales'], '0',1,'L',false);
        
        $pdf->SetFont('Arial','',16);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,'Precio de Venta', '0',1,'L',false);

        $pdf->Cell(100,6,'', '0');
        $pdf->Cell(80,6,number_format($inmueble['monto_vender'], 2, ',', '.').' BS', '0',1,'L',false);

        $pdf->SetFont('Arial','',6);

        $pdf->Cell(100,5,'', '0',1,'L',false);
        
        $pdf->Cell(100,5,'', '0',1,'L',false);
        


        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,6,'Seguridad', '0',1,'L',false);
       


        $pdf->SetFont('Arial','',10);

 $salto=0;

        if (!is_null($inmueble['vigilancia']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['vigilancia']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['vigilancia']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['sseguridad']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['sseguridad']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['sseguridad']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['pelectrico']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['pelectrico']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['pelectrico']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['cerca_electrica']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cerca_electrica']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cerca_electrica']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['cccseguridad']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cccseguridad']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cccseguridad']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['otros']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['otros']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['otros']), '0',1,'L',false);
            }
            
                
        }
        $pdf->SetFont('Arial','B',3);

    if ($salto!=3) {
        $pdf->Cell(100,3,'', '0',1,'L',false);
        
        	
        }

        $pdf->Cell(100,3,'', '0',1,'L',false);
        
        


        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,6,'Servicios', '0',1,'L',false);

        


        $pdf->SetFont('Arial','',10);

         
        $salto=0;

        if (!is_null($inmueble['linea_tlf']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['linea_tlf']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['linea_tlf']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['internet']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['internet']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['internet']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['lavanderia']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['lavanderia']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['lavanderia']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['Gimnasio']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['Gimnasio']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['Gimnasio']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['salon_de_fiestas']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['salon_de_fiestas']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['salon_de_fiestas']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['parque']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['parque']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['parque']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['piscina']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['piscina']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['piscina']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['Churuata']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['Churuata']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['Churuata']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['salon_juegos']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['salon_juegos']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['salon_juegos']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['cancha_deportiva']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cancha_deportiva']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cancha_deportiva']), '0',1,'L',false);
            }
            
                
        }

        $pdf->SetFont('Arial','B',3);

 if ($salto!=3) {
        $pdf->Cell(100,3,'', '0',1,'L',false);
        
        	
        }
        $pdf->Cell(100,3,'', '0',1,'L',false);
        


        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,6,'Informacion de Interes', '0',1,'L',false);

       


        $pdf->SetFont('Arial','',10);

        $salto=0;

        if (!is_null($inmueble['bdistribucion']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['bdistribucion']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['bdistribucion']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['cmontana']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cmontana']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cmontana']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['ceconomico']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['ceconomico']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['ceconomico']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['ccerrado']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['ccerrado']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['ccerrado']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['desocupado']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['desocupado']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['desocupado']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['eoportunidad']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['eoportunidad']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['eoportunidad']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['eubicacion']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['eubicacion']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['eubicacion']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['evista']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['evista']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['evista']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['mbonito']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['mbonito']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['mbonito']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['remodelado']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['remodelado']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['remodelado']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['aremodelar']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['aremodelar']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['aremodelar']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['vcomprarlo']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['vcomprarlo']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['vcomprarlo']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['ztranquila']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['ztranquila']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['ztranquila']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['areas_verdes']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['areas_verdes']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['areas_verdes']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['amueblado']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['amueblado']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['amueblado']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['Lobby']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['Lobby']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['Lobby']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['Reservorio']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['Reservorio']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['Reservorio']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['rio']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['rio']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['rio']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['bbq']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['bbq']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['bbq']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['Quebrada']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['Quebrada']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['Quebrada']), '0',1,'L',false);
            }
            
                
        }

        if (isset($inmueble['terrazaa'])) {

        if (isset($inmueble['terrazaa'])) {

        }

            # code...
        

            if (!is_null($inmueble['terrazaa']) ) {

                $salto++;

                if($salto==3){
                    $pdf->Cell(60,6,utf8_decode($inmueble['terrazaa']), '0',1,'L',false);
                    $salto=0;
                }else{
                    $pdf->Cell(60,6,utf8_decode($inmueble['terrazaa']), '0',1,'L',false);
                }
                
                    
            }

        }

        if (isset($inmueble['balcon'])) {

            if (!is_null($inmueble['balcon']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['balcon']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['balcon']), '0',1,'L',false);
            }
            
                
        }



        }


        
        $pdf->SetFont('Arial','B',3);

 if ($salto!=3) {
        $pdf->Cell(100,3,'', '0',1,'L',false);
        
        	
        }
        $pdf->Cell(100,3,'', '0',1,'L',false);
        
        


        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,6,'Cercanias', '0',1,'L',false);

        


        $pdf->SetFont('Arial','',10);

         
        $salto=0;

        if (!is_null($inmueble['abastos']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['abastos']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['abastos']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['ccomercial']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['ccomercial']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['ccomercial']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['panaderia']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['panaderia']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['panaderia']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['metro']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['metro']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['metro']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['taxi']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['taxi']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['taxi']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['clinica']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['clinica']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['clinica']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['colegios']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['colegios']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['colegios']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['farmacia']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['farmacia']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['farmacia']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['epublico']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['epublico']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['epublico']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['supermercado']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['supermercado']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['supermercado']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['hospital']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['hospital']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['hospital']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['bancos']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['bancos']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['bancos']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['comercios']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['comercios']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['comercios']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['restaurant']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['restaurant']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['restaurant']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['publico']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['publico']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['publico']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['autopista']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['autopista']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['autopista']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['carga']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['carga']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['carga']), '0',0,'L',false);
            }
            
                
        }

if (!is_null($inmueble['peatona']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['peatona']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['peatona']), '0',1,'L',false);
            }
            
                
        }
        $pdf->SetFont('Arial','B',3);

        if ($salto!=3) {
        $pdf->Cell(100,3,'', '0',1,'L',false);
        
        	
        }
        $pdf->Cell(100,3,'', '0',1,'L',false);






        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,6,'Legal', '0',1,'L',false);

        


        $pdf->SetFont('Arial','',10);

         
        $salto=0;

        if (!is_null($inmueble['personan']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['personan']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['personan']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['documentop']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['documentop']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['documentop']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['cedulac']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cedulac']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cedulac']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['solvenciam']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['solvenciam']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['solvenciam']), '0',0,'L',false);
            }
            
                
        }

        if (!is_null($inmueble['cedulap']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cedulap']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cedulap']), '0',0,'L',false);
            }
            
                
        }

        if (isset($inmueble['cedulaco'])) {

             if (!is_null($inmueble['cedulaco']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['cedulaco']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['cedulaco']), '0',0,'L',false);
            }
            
                
        }



        }



       

        if (!is_null($inmueble['poder']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['poder']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['poder']), '0',0,'L',false);
            }
            
                
        }


        if (isset($inmueble['hipoteca'])) {


            if (!is_null($inmueble['hipoteca']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['hipoteca']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['hipoteca']), '0',0,'L',false);
            }
            
                
        }

        }



        if (isset($inmueble['liberacion'])) {

             if (!is_null($inmueble['liberacion']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['liberacion']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['liberacion']), '0',0,'L',false);
            }
            
                
        }




        }

        

       







        
        


        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(80,6,'Condiciones de Venta', '0',1,'L',false);

        


        $pdf->SetFont('Arial','',10);

         
        $salto=0;

        if (!is_null($inmueble['contado']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['contado']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['contado']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['credito']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['credito']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['credito']), '0',0,'L',false);
            }
            
                
        }


if (!is_null($inmueble['convenir']) ) {

            $salto++;

            if($salto==3){
                $pdf->Cell(60,6,utf8_decode($inmueble['convenir']), '0',1,'L',false);
                $salto=0;
            }else{
                $pdf->Cell(60,6,utf8_decode($inmueble['convenir']), '0',0,'L',false);
            }
            
                
        }



       
        $pdf->Output('I', 'inmueble.pdf' );
       
    }



 private function generacorreo($email, $nombre, $message,  $asunto){

            $destinatario = $email; 
            
            #$asunto = "Gracias por Registrarse En Albatros Airlines"; 
                    
                    $cuerpo='
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
      <title>DPT Propiedades</title>
      
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
                                            <!-- <td width="30" height="30" align="right">
                                                <div class="imgpop">
                                                   <a target="_blank" href="https://facebook.com/decohouse">
                                                   <img src="http://localhost/decohouse.com.ve/assets/images/redes/facebook.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             
                                             <td width="30" height="30" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="https://twitter.com/decohouse">
                                                   <img src="http://localhost/decohouse.com.ve/assets/images/redes/twitter.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             <td width="30" height="30" align="center">
                                                <div class="imgpop">
                                                   <a  target="_blank" href="https://twitter.com/decohouse">
                                                   <img src="http://localhost/decohouse.com.ve/assets/images/redes/insta.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td> -->
                                             
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
                                       <a target="_blank" href="encasaplus.com"><img  border="0" height="200" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" src="http://encasaplus.com/android/assets/images/EnCasaPlus.png" class="banner"></a>
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
                                             <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 30px; color: #146eb4      ; text-align:center; line-height: 30px;" st-title="fulltext-heading">
                                                Hola '.$nombre.' 

                                             </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style="font-family: \'Open Sans\', sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                               Hemos Recibido la siguiente consulta: <br>
                                               '.$message.'<br>
                                               
                                               <br>
                                               Pronto nos pondremos en contacto con usted, Muchas Gracias por su interes.

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
                                                <img src="http://encasaplus.com/assets/img/1e1a6a704650b36b62fd46ea97c96cc5.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
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
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #146eb4      ; text-align:center; line-height: 24px;" st-title="3col-title1">
                                                            <a href="http://encasaplus.com/">  PROPIEDADES EXCLUSIVAS </a>
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
                                                            Nuestro portal cuenta con la mejor selecci�n de inmuebles en Caracas, Maracay, Valencia y muchas otras ciudades
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
                                                <img src="http://encasaplus.com/assets/img/68ed7348097ca487e33bc9d90a06c587.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
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
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #146eb4      ; text-align:center; line-height: 24px;" st-title="3col-title2">
                                                            EL MEJOR PRECIO DEL MERCADO
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
                                                            Una vez que encuentres el inmueble adecuado, DTP Propiedades te proporcionar� la informacion de contacto necesaria para que te comuniques con el agente inmobiliario, ya sea v�a email o por telefono
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
                                                <img src="http://encasaplus.com/assets/img/be9e67cf72ab499a2659fec3e94ac977.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
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
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 18px; font-weight: 700; color: #146eb4      ; text-align:center; line-height: 24px;" st-title="3col-title3">
                                                            TODO LO QUE BUSCAS
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
                                                            Dentro de nuestro catalogo podris encontrar todo tipo de inmuebles en venta y arriendo a lo largo y ancho de Venezuela.
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
                  <td style="width: 35%;"></td><td style="width: 15%;"></td>
                     <td align="right" height="50" style="font-size:10px; line-height:1px; text-align: right;">
                           Diseñado y Desarrollado Por: 
                     </td>
                     <td align="center" height="50" style="font-size:12px; line-height:1px; text-align: left;">
                           
                              <a target="_blank" href="http://www.maymi.com.ve">
                                 <img src="http://www.encasaplus.com/assets/img/logo_maymi.png" alt="" height="20" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
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

                    //para el envío en formato HTML 
                    $headers = "MIME-Version: 1.0\r\n"; 
                    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

                    //dirección del remitente 
                   $headers .= "From: EnCasaPlus  <info@encasaplus.com>\r\n"; 

                    //dirección de respuesta, si queremos que sea distinta que la del remitente 
                    //$headers .= "Reply-To: sistemas@albatrosair.aero\r\n"; 

                    //ruta del mensaje desde origen a destino 
                    //$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

                    //direcciones que recibián copia 
                    #$headers .= "Cc: ".$email2."\r\n"; 

                    //direcciones que recibirán copia oculta 
                  $headers .= "Bcc: miguelmachadoaa@gmail.com\r\n"; 
                   # $headers .= "Bcc: agenciasdeviaje@albatrosair.aero\r\n"; 
                   # $headers .= "Bcc: cuentasxcobrar@albatrosair.aero\r\n";
                   # $headers .= "Bcc: orlando.padilla@albatrosair.aero\r\n";
                   # $headers .= "Bcc: orlando.padilla@albatrosair.aero\r\n";
                    
                   $respuesta=mail($destinatario,$asunto,$cuerpo,$headers);


                   return $respuesta;


    }

}