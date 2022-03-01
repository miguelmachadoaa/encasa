<?php

class SolicitudController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        
    }

    public function listAction(){
        
       $ObjServicios= new Application_Model_DbTable_Servicios();

      
        $this->view->servicios = $ObjServicios->fetchAll();
        
       
        
        
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        $page = $this->_getParam('page', 1);
            
        $paginator = Zend_Paginator::factory($ObjServicios->fetchAll());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        $this->view->paginator = $paginator;
        
    }

    public function indexAction(){


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

     public function notificacionAction(){

        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

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

     public function notificacioninAction(){

        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

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

         public function notificacionmuAction(){

        $id = $this->_getParam('id', 0);

        $this->view->id=$id;

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

     public function presupuestoAction(){



        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


         if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();

            unset($formData['btn_submit']);

            $id=$formData['id'];
            
            $data = array(
            'id' => $formData['id'],
            'nombres' => $formData['nombres'],
            'apellidos' => $formData['apellidos'],
            'tlf' => $formData['tlf'],
            'tlf_movil' => $formData['tlf_movil'],
            'email' => $formData['email'],
            'empresa' => $formData['empresa'],
            'rif' => $formData['rif'],
            'ciudad' => $formData['ciudad'],
            'tipo' => $formData['tipo'],
            'cantidad' => $formData['cantidad'],
            'descripcion' => $formData['descripcion'],
            'estatus' => '1',
            );

             $ObjPresupuesto= new Application_Model_DbTable_Presupuesto();
                
        if ($ObjPresupuesto->add($formData)) {


            $id=$formData['id'];
            $nombre=$formData['nombres'].' '.$formData['apellidos'];
            $titulo=' Hemos recibido una solicitud de presupuesto para un avaluo ';
            $message='El id de su solicitud es: <h3>'.$id.'</h3> con este podra consultar el estado de su solicitud en la pagina web, de igual forma podra cargar el pago correspondiente por el servicio. Tambien puede consultar su solicitud haciendo click en el enlace <a href="http://tirex2021.esy.es/mueble/ver/id/'.$id.'" >Consultar</a>';
            $asunto='Solicitud de Avaluo  Tirex2021 C.A.';

            $enviado=$this->generacorreo($formData['email'], $nombre, $message, $asunto, $titulo );



                   $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/solicitud/notificacion/id/'.$id);
                


                }else{
                    $this->_redirect('/solicitud/presupuesto/id/'.$id);
                }
                

            
        }



        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');
        
    }

    public function auditarAction(){



        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');



         if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            $id=$formData['id'];
            

            $data_mueble = array(
            'id' => $formData['id'],
            'nombres' => $formData['nombres'],
            'apellidos' => $formData['apellidos'],
            'tlf' => $formData['tlf'],
            'tlf_movil' => $formData['tlf_movil'],
            'email' => $formData['email']
            );

            $ObjAuditoria = new Application_Model_DbTable_Auditoria();

            $ObjAuditoria->add($data_mueble);


            $id=$formData['id'];
            
            $nombre=$formData['nombres'].' '.$formData['apellidos'];
            
            $titulo=' Hemos recibido una solicitud de Auditoria de Informe';
            
            $message='El id de su solicitud es: <h3>'.$id.'</h3> con este podra consultar el estado de su solicitud en la pagina web, de igual forma podra cargar el pago correspondiente por el servicio. Tambien puede consultar su solicitud haciendo click en el enlace <a href="http://tirex2021.esy.es/mueble/ver/id/'.$id.'" >Consultar</a>';
            
            $asunto='Solicitud de auditoria de Informe de Tasacion Tirex2021 C.A.';

            $enviado=$this->generacorreo($formData['email'], $nombre, $message, $asunto, $titulo );


                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/solicitud/notificacion/id/'.$id);

            
        }

    }

    public function validadorAction(){



        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');



         if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            

            $id=$formData['id'];
            

            $data_mueble = array(
            'id' => $formData['id'],
            'dpt' => $formData['dpt'],
            'cvt' => $formData['cvt'],
            'email' => $formData['email']
            );

            $ObjValidador = new Application_Model_DbTable_Validador();

            $ObjValidador->add($data_mueble);

            $id=$formData['id'];
            
            $nombre='';
            
            $titulo=' Hemos recibido una solicitud de Validacion de un Informe';
            
            $message='El id de su solicitud es: <h3>'.$id.'</h3> con este podra consultar el estado de su solicitud en la pagina web. Tambien puede consultar su solicitud haciendo click en el enlace <a href="http://tirex2021.esy.es/mueble/ver/id/'.$id.'" >Consultar</a>';
            
            $asunto='Solicitud de Validacion de Informe Tirex2021 C.A.';

            $enviado=$this->generacorreo($formData['email'], $nombre, $message, $asunto, $titulo );

            $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
            $this->_redirect('/solicitud/notificacion/id/'.$id);

            
        }

    }


      public function muebleAction(){



        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');



         if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
        
            $id=$formData['id'];
            

            $data_mueble = array(
            'id' => $formData['id'],
            'nombres' => $formData['nombres'],
            'apellidos' => $formData['apellidos'],
            'cedula' => $formData['cedula'],
            'tlf' => $formData['tlf'],
            'tlf_movil' => $formData['tlf_movil'],
            'email' => $formData['email'],
            'cantidad' => $formData['cantidad'],
            'estado' => $formData['estado'],
            'ciudad' => $formData['ciudad'],
            'direccion' => $formData['direccion']
            );

            $ObjMueble = new Application_Model_DbTable_Mueble();

            $ObjMueble->add($data_mueble);



            $data_bien = array(
            'id_mueble' => $formData['id'],
            'tipo_bien' => $formData['tipo_bien'],
            'cantidad_bien' => $formData['cantidad_bien'],
            'marca' => $formData['marca'],
            'modelo' => $formData['modelo'],
            'edad_bien' => $formData['edad_bien'],
            'conservacion_bien' => $formData['conservacion_bien'],
            'tecnologia_bien' => $formData['tecnologia_bien'],
            'mantenimiento_bien' => $formData['mantenimiento_bien'],
            'observacion_bien' => $formData['observacion_bien'],
            'imagen' => $new_file
            );
                
             $ObjBienes = new Application_Model_DbTable_Bienes();
                
            $res=$ObjBienes->add($data_bien);

            //var_dump($res);


            $id=$formData['id'];
            $nombre=$formData['nombres'].' '.$formData['apellidos'];
            $titulo=' Hemos recibido una solicitud de avaluo online de un Bien Mueble';
            $message='El id de su solicitud es: <h3>'.$id.'</h3> con este podra consultar el estado de su solicitud en la pagina web, de igual forma podra cargar el pago correspondiente por el servicio. Tambien puede consultar su solicitud haciendo click en el enlace <a href="http://tirex2021.esy.es/mueble/ver/id/'.$id.'" >Consultar</a>';
            $asunto='Solicitud de Avaluo Online de Bien Mueble Tirex2021 C.A.';

            $enviado=$this->generacorreo($formData['email'], $nombre, $message, $asunto, $titulo);

            $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
            $this->_redirect('/solicitud/notificacionin/id/'.$id);
            
        }




    }

    public function inmuebleAction(){

        $opt=array('layout'=>'layout');

        Zend_Layout::startMvc($opt);


        $ObjSliders = new Application_Model_DbTable_Sliders();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();
        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');





        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            

            $id=$formData['id'];
            $nombre=$formData['nombres'].' '.$formData['apellidos'];
            $titulo=' Hemos recibido una solicitud de avaluo online de un Bien Inmueble';
            $message='El id de su solicitud es: <h3>'.$id.'</h3> con este podra consultar el estado de su solicitud en la pagina web, de igual forma podra cargar el pago correspondiente por el servicio. Tambien puede consultar su solicitud haciendo click en el enlace <a href="http://tirex2021.esy.es/mueble/ver/id/'.$id.'" >Consultar</a>';
            $asunto='Solicitud de Avaluo Online de Bien Inmueble Tirex2021 C.A.';
            

            unset($formData['btn_submit']);
            unset($formData['MAX_FILE_SIZE']);


                
             $ObjInmueble = new Application_Model_DbTable_Inmueble();
                
            $ObjInmueble->add($formData);


            $enviado=$this->generacorreo($formData['email'], $nombre, $message, $asunto, $titulo );



                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado con éxito!'));
                
                $this->_redirect('/solicitud/notificacion/id/'.$id);

        }

        
    }


     private function getFileExtension($filename)
        {
            $fext_tmp = explode('.',$filename);
            return $fext_tmp[(count($fext_tmp) - 1)];
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







private function generacorreo($email, $nombre, $message, $asunto, $titulo ){

            $destinatario = $email; 
            
            
                    
$cuerpo='
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
      <title>Diseños y Proyectos Tirex 2021 C.A.</title>
      
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
                                       <a target="_blank" href="chronikapp.com"><img  border="0" height="300" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" src="http://tirex2021.esy.es/assets/img/6b1a00785b1ae5703544cc446e5d7505.jpg" class="banner"></a>
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
                                               '.$titulo.': <br>
                                               '.$message.'<br>
                                               <br>
                                               Pronto es pondremos en contacto con usted, Muchas Gracias por su interes.

                                             </td>
                                          </tr>
                                          <tr>
                                             <td style="font-family: \'Open Sans\', sans-serif; font-size: 16px; color: #666666; text-align:left; line-height: 30px;" st-content="fulltext-content">

                                               <br>Para Realizar los pagos a los servicios prestados por la empresa cuenta con la siguientes datos:<br>

                                               Depósito o Transferencia bancaria a nombre de:<br>
                                                Diseños y Proyectos Tirex 2021, C.A., RIF: J-40326241-1.<br>
                                                Cuenta Corriente Nº: 0134-1020-86-0001004019.<br>
                                                Banco: Banesco.<br>






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
                                                <img src="http://tirex2021.esy.es/assets/img/7fb4b04d4c764d6b1491dc8a9c9ec4db.png" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
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
                                                            <a href="www.tirex2021.com/"> VALORACION ONLINE </a>
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
                                                            El tiempo es el bien más valioso en la actualidad, es por ello que en Diseños Y Proyectos Tirex 2021 C.A
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
                                                <img src="http://tirex2021.esy.es/assets/img/7fb4b04d4c764d6b1491dc8a9c9ec4db.png" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
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
                                                            VALIDADOR DE INFORME
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
                                                            A través de nuestra página web, usted podrá comprobar la autenticidad de los Informes Técnicos de Avalúos emitidos por Diseños y Proyectos Tirex 2021, C.A 
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
                                                <img src="http://tirex2021.esy.es/assets/img/6d0b8b9ddbc0b962d4852dbfd3ad038d.png" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
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
                                                            AUDITORIAS DE TASACIONES
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
                                                            Con la finalidad de obtener una segunda Opinión de Valor que justifique una decisión importante para una Institución, Diseños y Proyectos Tirex 2021, C.A.
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
                                                            <img src="http://tirex2021.esy.es/assets/img/e3586ae6b067234195b742c649d8f030.jpg" alt="" border="0" width="160" height="160" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
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
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #146eb4      ; line-height:24px;text-align:center;" st-title="2coltitle1">
                                                                        Quienes Somos
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; line-height:24px; color: #666666; text-align:center;" st-conteent="2colcontent1">
                                                                        Diseños y Proyectos Tirex 2021, C.A., es una empresa que reúne a un grupo de Profesionales – Avaluadores con formación diversa en Avalúos Inmobiliarios y Mobiliarios, con el hábito y visión de trabajo en equipo para brindarle a sus clientes un servicio de calidad y excelencia.
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
                                                            <img src="http://tirex2021.esy.es/assets/img/074037ad19596ca245729bfa7025b4b5.jpg" alt="" border="0" width="160" height="160" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
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
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #146eb4      ;line-height:24px; text-align:center;" st-title="2coltitle2">
                                                                        Objetivos
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td width="100%" height="20"></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; line-height:24px; color: #666666; text-align:center;" st-content="2colcontent2">
                                                                        Ser la empresa líder en la optimización, automatización y asesoramiento de los métodos tradicionales de valoración establecidos en la elaboración de avalúos con el objetivo de reducir los tiempos, digitalizando en gran parte nuestros informes con la finalidad de contribuir con el medio ambiente.
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
                                                   <img src="http://tirex2021.esy.es/assets/archivos/procesadas/logo_apaisado.png" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
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
                  <td style="width: 35%;"></td><td style="width: 15%;"></td>
                     <td align="right" height="50" style="font-size:10px; line-height:1px; text-align: right;">
                           Diseñado y Desarrollado Por: 
                     </td>
                     <td align="center" height="50" style="font-size:12px; line-height:1px; text-align: left;">
                           
                              <a target="_blank" href="http://www.maymi.com.ve">
                                 <img src="http://tirex2021.esy.es/assets/img/logo_maymi.png" alt="" height="20" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
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
                    $headers .= "From: Diseños y Proyectos Tirex 2021 C.A. <info@tirex2021.com>\r\n"; 

                    //dirección de respuesta, si queremos que sea distinta que la del remitente 
                    //$headers .= "Reply-To: sistemas@albatrosair.aero\r\n"; 

                    //ruta del mensaje desde origen a destino 
                    //$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

                    //direcciones que recibián copia 
                    #$headers .= "Cc: ".$email2."\r\n"; 

                    //direcciones que recibirán copia oculta 
                   $headers .= "Bcc: miguelachadoaa@gmail.com\r\n"; 
                    
                    mail($destinatario,$asunto,$cuerpo,$headers);

    }







}







