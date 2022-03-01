<?php
class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout('layout')->disableLayout();
    }

    public function delpropietarioAction()
    {

        $id = $this->_getParam('id');

        $res=null;
        
        if ($id) {

          $ObjPropietario = new Application_Model_DbTable_Propietario();

          $pro=$ObjPropietario->fetchRow('id="'.$id.'"');

          $ObjPropietario->del($id);       

        }

        $this->view->res=$ObjPropietario->fetchAll('id_propiedad="'.$pro['id_propiedad'].'"');

      }

    public function registrarpropietarioAction()
    {

      $auth = Zend_Auth::getInstance();

        $this->view->auth = $auth;

        $id_user=$auth->getIdentity()->uid;

        $id = $this->_getParam('id');

        $nombre_propietario = $this->_getParam('nombre_propietario');

        $apellido_propietario = $this->_getParam('apellido_propietario');

        $fecha_nacimiento_propietario = $this->_getParam('fecha_nacimiento_propietario');

        $telefono_propietario = $this->_getParam('telefono_propietario');

        $email_propietario = $this->_getParam('email_propietario');

        $res=null;
        
        if ($id) {

        $ObjPropietario = new Application_Model_DbTable_Propietario();

        list($dia,$mes,$ano)=explode("/",$fecha_nacimiento_propietario);

        $fecha=$ano.'-'.$mes.'-'.$dia;

        $data = array(
          'id_propiedad' => $id,
          'nombre_propietario' => $nombre_propietario,
          'apellido_propietario' => $apellido_propietario,
          'fecha_nacimiento_propietario' =>  date('Y-m-d',strtotime($fecha_nacimiento_propietario)),
          'telefono_propietario' => $telefono_propietario,
          'email_propietario' => $email_propietario
        );
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjPropietario->add($data);

        }

        $this->view->res=$ObjPropietario->fetchAll('id_propiedad="'.$id.'"');

      }


    public function recuperarAction()
    {


        $email = $this->_getParam('email');

        //echo $email.$clave;
        
        if ($email) {

        $ObjUsers = new Application_Model_DbTable_Users();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

     
        #$user=$ObjUsers->CheckUsuario($email, md5($clave));
        $user=$ObjUsers->fetchRow('email="'.$email.'"');

        #var_dump($user);

         if ($user->id) {

            $enlace="www.encasaplus.com/auth/recuperar/key/".$user->key;

          $id=$user->id;



          $mensaje="Se ha solicitado el reinicio de su clave de acceso<br>";
          $mensaje=$mensaje."  Si usted solicito el reinicio siga el siguente enlace <a target='_blank' href='".$enlace."'> Reiniciar Clave </a> <br>";
          $mensaje=$mensaje."  o copie esta url y pegala en el navegador ".$enlace."<br>";
          $mensaje=$mensaje."  De no se asi ignore este correo";

          $asunto="Dpt propiedades Reinicio de Contraseña";

          $respuesta=$this->generacorreo($email, $user->name, $mensaje,  $asunto);

          if ($respuesta) {
            echo "true";
          }else{
            echo "false";
          }

        }else{

            echo "no se encontro usuario";
          
        }


    }else{
      echo "no se recibieron datos";
    }

  }


    public function accederAction()
    {


        $email = $this->_getParam('email');
        $clave = $this->_getParam('clave');

        //echo $email.$clave;
        
        if ($email) {

        $ObjUsers = new Application_Model_DbTable_Users();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

     
        #$user=$ObjUsers->CheckUsuario($email, md5($clave));
        $user=$ObjUsers->fetchRow('email="'.$email.'"');

        #var_dump($user);

         if ($user->id) {

            if ($user->password==md5($clave)) {
              

            try {

              $this->_auth = Zend_Auth::getInstance();

              $this->_auth->clearIdentity();

               $roles = new Application_Model_DbTable_Roles();
                    
                    $role = $roles->getRoleName($user->role_id);

               $identity = new stdClass();
                $identity->uid = $user->id;
                $identity->name = $user->name;
                $identity->lastname = $user->lastname;
                $identity->username = $user->username;
                $identity->role = $role;
                $identity->role_id = $user->role_id;
                $identity->state = $user->state_id;
                      
                $this->_auth->getStorage()->write($identity);

               
               

                echo "true";
               
             } catch (Exception $e) {

               echo $e;
             } 

            }else{

              echo 'clave incorrecta';

            }

            

        }else{

            echo "usuario incorrecto";
          
        }


    }else{
      echo "no se recibieron datos";
    }

  }




    public function registrarusuarioAction()
    {

      

        $username = $this->_getParam('username');
        $email = $this->_getParam('email');
        $clave = $this->_getParam('clave');
        
        if ($username) {

        $ObjUsers = new Application_Model_DbTable_Users();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $data = array( 
          'name' => '',
          'lastname' => '',
          'email' => $email,
          'telefono' => '',
          'movil' => '',
          'state_id' => '0',
          'city_id' => '',
          'username' => $username,
          'password' => md5($clave),
          'key' => md5($clave.$clave),
          'role_id' => '4',
           );

        try {
          
          $ObjUsers->addUser( $data);

          $user=$ObjUsers->fetchRow('email="'.$email.'"');

            

            $this->_auth = Zend_Auth::getInstance();

             $identity = new stdClass();
              $identity->uid = $user['id'];
              $identity->name = $user['name'];
              $identity->lastname = $user['lastname'];
              $identity->username = $user['username'];
              $identity->role = 'asesor';
              $identity->role_id = $user['role_id'];
              $identity->state = $user['state_id'];
                    
              $this->_auth->getStorage()->write($identity);
                    
              
              //$this->_redirect('/administrador/perfil/');

              echo "true";

        } catch (Exception $e) {

           echo "false";
          
        }

        

          

        }else{

            echo "false";
          
        }


    }


            public function eliminarAction()
    {

        $id = $this->_getParam('id');
        $modelo = $this->_getParam('modelo');

        
        if ($id) {

          switch ($modelo) {
            case 'auditoria':
                $Obj = new Application_Model_DbTable_Auditoria();
              # code...
              break;

          case 'inmueble':
                $Obj = new Application_Model_DbTable_Inmueble();
              # code...
              break;

          case 'fotos':
                $Obj = new Application_Model_DbTable_Fotos();
              # code...
              break;

          case 'validador':
                $Obj = new Application_Model_DbTable_Validador();
              # code...
              break;

          case 'presupuesto':
                $Obj = new Application_Model_DbTable_Presupuesto();
              # code...
              break;

              case 'cocina':
                $Obj = new Application_Model_DbTable_Cocinas();
              # code...
              break; 

              case 'topes':
                $Obj = new Application_Model_DbTable_Topes();
              # code...
              break;   

              case 'mobiliario':
                $Obj = new Application_Model_DbTable_Mobiliario();
              # code...
              break; 

              case 'dormitorios':
                $Obj = new Application_Model_DbTable_Dormitorios();
              # code...
              break;  

              case 'banos':
                $Obj = new Application_Model_DbTable_Banos();
              # code...
              break;  

               case 'asesores':
                $Obj = new Application_Model_DbTable_Asesores();
              # code...
              break;    

              case 'estados':
                $Obj = new Application_Model_DbTable_Estados();
              # code...
              break;  

              case 'users':
                $Obj = new Application_Model_DbTable_Users();
              # code...
              break;       
            default:
              # code...
              break;
          }

        // se envia a la vista todos los registros de usuarios
        
           $res=$Obj->del($id);
           echo $res;

        }

        

       
    }



    public function estatusAction()
    {

        $id = $this->_getParam('id');
        $modelo = $this->_getParam('modelo');
        $estatus = $this->_getParam('estatus');

        
        if ($id) {

          switch ($modelo) {
            case 'auditoria':
                $Obj = new Application_Model_DbTable_Auditoria();
              # code...
              break;

              case 'aerolinea':
                $Obj = new Application_Model_DbTable_Aerolineas();
              # code...
              break;

          case 'inmueble':
                $Obj = new Application_Model_DbTable_Inmueble();
              # code...
              break;

          case 'mueble':
                $Obj = new Application_Model_DbTable_Mueble();
              # code...
              break;

          case 'validador':
                $Obj = new Application_Model_DbTable_Validador();
              # code...
              break;

          case 'presupuesto':
                $Obj = new Application_Model_DbTable_Presupuesto();
              # code...
              break;

          case 'pagina':
                $Obj = new Application_Model_DbTable_Paginas();
              # code...
              break;

          case 'hoteles':
                $Obj = new Application_Model_DbTable_Hoteles();
              # code...
              break;     

               case 'cocina':
                $Obj = new Application_Model_DbTable_Cocinas();
              # code...
              break; 

              case 'topes':
                $Obj = new Application_Model_DbTable_Topes();
              # code...
              break;   

              case 'mobiliario':
                $Obj = new Application_Model_DbTable_Mobiliario();
              # code...
              break; 

              case 'dormitorios':
                $Obj = new Application_Model_DbTable_Dormitorios();
              # code...
              break;  

              case 'banos':
                $Obj = new Application_Model_DbTable_Banos();
              # code...
              break;  

                case 'asesores':
                $Obj = new Application_Model_DbTable_Asesores();
              # code...
              break; 

              case 'estados':
                $Obj = new Application_Model_DbTable_Estados();
              # code...
              break;   

              case 'ciudades':
                $Obj = new Application_Model_DbTable_Ciudades();
              # code...
              break; 

              case 'zonas':
                $Obj = new Application_Model_DbTable_Zonas();
              # code...
              break;           
            default:
              # code...
              break;
          }

          $data = array('estatus' => $estatus );
      
        // se envia a la vista todos los registros de usuarios
        
           $res=$Obj->upd($id, $data);

           $this->view->modelo=$modelo;
           $this->view->id=$id;
           $this->view->estatus=$estatus;

        }

       
    }

         public function updatetipoAction()
    {

        $id = $this->_getParam('id');
        $tipo = $this->_getParam('tipo');
        
        if ($id) {

       
        $ObjInmueble = new Application_Model_DbTable_Inmueble();

      

        $data = array('destacado' => $tipo
        );
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjInmueble->upd($id, $data);
          

        }else{


        }


          $inmueble=$ObjInmueble->getInmueble($id);

          $this->view->inmueble=$inmueble;

          $enlace="www.encasaplus.com/inmueble/ver/id/".$inmueble->id;

          $id=$inmueble->id;



          $mensaje="El Inmubele ".$inmueble->titulo." han sido actualizado al tipo de publiacion";
          $mensaje=$mensaje." <b>".strtoupper($inmueble->destacado). " </b> para ver los cambios del mismo puede hacerlo en el enlace <a target='_blank' href='".$enlace."'> Ver </a> <br>";

          $asunto="Actualizacion del Inmueble ".$inmueble->titulo;

          $respuesta=$this->generacorreo($inmueble->email, $inmueble->name, $mensaje,  $asunto);


         // $this->view->inmueble=$ObjInmueble->fetchRow('id="'.$id.'"');
        // $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);



       
    }

    public function guardarventaAction()
    {

      $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        $id_user=$auth->getIdentity()->uid;


        $id = $this->_getParam('id');
        $estatus = $this->_getParam('estatus');
        $id_captador = $this->_getParam('id_captador');
        $id_cerrador = $this->_getParam('id_cerrador');
        $monto_venta = $this->_getParam('monto_venta');
        $comision = $this->_getParam('comision');

        $res=null;
        
        if ($id) {

       
        $ObjVenta = new Application_Model_DbTable_Venta();

      

        $data = array(
          'id_inmueble' => $id,
          'id_captador' => $id_captador,
          'id_cerrador' => $id_cerrador,
          'tipo' => '',
          'monto_venta' => $monto_venta,
          'comision' => $comision,
          'id_user' => $id_user
        );
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjVenta->add($data);

          

        }

        echo $res;


       
    }


    public function updateestatusAction()
    {

        $id = $this->_getParam('id');
        $estatus = $this->_getParam('estatus');
        
        if ($id) {

       
        $ObjInmueble = new Application_Model_DbTable_Inmueble();

      

        $data = array('estatus' => $estatus
        );
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjInmueble->upd($id, $data);

          

        }else{
        }


         $inmueble=$ObjInmueble->getInmueble($id);

          $this->view->inmueble=$inmueble;

          $enlace="www.encasaplus.com/inmueble/ver/id/".$inmueble->id;

          $id=$inmueble->id;

          $mensaje="El Inmueble ".$inmueble->titulo." han sido actualizado al estatus ";
          $mensaje=$mensaje." <b>".strtoupper($inmueble->estatus). " </b> para ver los cambios del mismo puede hacerlo en el enlace <a target='_blank' href='".$enlace."'> Ver </a> <br>";

          $asunto="Actualizacion del Inmueble ".$inmueble->titulo;

          $respuesta=$this->generacorreo($inmueble->email, $inmueble->name, $mensaje,  $asunto);



          //$this->view->inmueble=$ObjInmueble->fetchRow('id="'.$id.'"');
        // $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);



       
    }

    




    public function busquedaAction()
    {

         $term = $this->_getParam('term');


        $ObjEstados = new Application_Model_DbTable_Estados();
        $ObjCiudades = new Application_Model_DbTable_Ciudades();
        $ObjZonas = new Application_Model_DbTable_Zonas();
        
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $res = array();

        $estados=$ObjEstados->like($term);
        
        $zonas=$ObjZonas->like($term);
        $ciudades=$ObjCiudades->like($term);
        

        foreach ($estados as $esta) {

          $valor = array('tipo' =>'f_estado' ,'id' =>$esta->id , 'descripcion' =>utf8_decode($esta->estado));

          $res[]=$valor;
          
        }

        foreach ($zonas as $zona) {

          $valor = array('tipo' =>'f_zona' ,'id' =>$zona->id , 'descripcion' =>utf8_decode($zona->zona.' , '.$zona->ciudad.''));

          $res[]=$valor;
          

        }

        

         foreach ($ciudades as $ciudad) {

          $valor = array('tipo' =>'f_ciudad' ,'id' =>$ciudad->id , 'descripcion' =>utf8_decode($ciudad->ciudad.' , '.$ciudad->estado));

          $res[]=$valor;
          
        }

         


        $respuesta=json_encode($res);

        echo $respuesta;


    }

    public function compartirnegocioAction()
    {

      $id_compartir=time();

        $id = $this->_getParam('compartir_id');
        $comision = $this->_getParam('comision_negocio');
        $condicion = $this->_getParam('condicion_negocio');
        
        if ($id) {

        $ObjCompartir = new Application_Model_DbTable_Compartir();
        
        $ObjInmueble = new Application_Model_DbTable_Inmueble();

        $data = array(
          'id'=>$id_compartir,
          'id_inmueble' => $id,
          'comision' => $comision,
          'condiciones' => $condicion,
           );

        $data_upd = array(
          'compartido' => 'si',
           );


        $ObjCompartir->add($data);

        $ObjInmueble->upd($id, $data_upd);

            $this->view->data=$ObjCompartir->fetchRow('id="'.$id_compartir.'"');

        }else{

           $this->view->data='';
          
        }


    }

     public function borrarimagenAction()
    {

      

        $url = $this->_getParam('urlimagen');
        
        if ($url) {

          try {
            unlink($url);
          } catch (Exception $e) {
            echo $e;
          }

          echo "true";

        }else{

            echo "false";
          
        }


    }

    public function negocioAction()
    {

        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        $id_user=$auth->getIdentity()->uid;

        $id = $this->_getParam('id');
        $compartido = $this->_getParam('compartido');
        $tipo = $this->_getParam('tipo');
        
        if ($id) {

        $ObjNegocio = new Application_Model_DbTable_Negocio();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $respuesta=$ObjNegocio->buscar($id, $compartido, $id_user);
        
        echo $respuesta['id'];

        if(isset($respuesta['id'])){

          $data=array('tipo' => $tipo );

            $ObjNegocio->upd($respuesta->id, $data);

            echo "true upd";


        }else{

          $data=array(
            'id_compartido' => $compartido, 
            'id_inmueble' => $id,
            'id_usuario' => $id_user,
            'tipo' => $tipo
            );

            $ObjNegocio->add( $data);

            echo "true add";



        }

        

            
        }else{

            echo "false";
          
        }


    }

    public function confirmaralianzaAction()
    {

      

        $id = $this->_getParam('id');
        
        if ($id) {

        $ObjSolicitud = new Application_Model_DbTable_Solicitud();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $data = array('estatus' => 'confirmado', );

        $ObjSolicitud->upd($id, $data);

            echo "true";

        }else{

            echo "false";
          
        }


    }

    public function rechazaralianzaAction()
    {

      

        $id = $this->_getParam('id');
        
        if ($id) {

        $ObjSolicitud = new Application_Model_DbTable_Solicitud();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $data = array('estatus' => 'rechazado', );

        $ObjSolicitud->upd($id, $data);

            echo "true";

        }else{

            echo "false";
          
        }


    }


     public function enviaralianzaAction()
    {

      

        $emisor = $this->_getParam('emisor');
        $receptor = $this->_getParam('receptor');
        
        if ($emisor) {

        $ObjSolicitud = new Application_Model_DbTable_Solicitud();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $data = array(
          'emisor' => $emisor, 
          'receptor' => $receptor
          );

        $ObjSolicitud->add($data);

            echo "true";

        }else{

            echo "false";
          
        }


    }




     public function mostrarusuarioAction()
    {

      $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        $id_user=$auth->getIdentity()->uid;



        $id = $this->_getParam('id');
        
        if ($id) {

        $ObjUsers = new Application_Model_DbTable_Users();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $this->view->usuario=$ObjUsers->getUsuario($id);
        $this->view->id_user=$id_user;
        
        }else{

          $this->view->usuario="false";
        }


    }


     public function cargarciudadAction()
    {

        $estado = $this->_getParam('estado');
        
        if ($estado) {

        $ObjCiudades = new Application_Model_DbTable_Ciudades();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $this->view->ciudades=$ObjCiudades->fetchAll('id_estado="'.$estado.'"');
        
        }else{
          echo "false";
        }


    }

     public function cargarmunicipioAction()
    {

        $estado = $this->_getParam('estado');
        
        if ($estado) {

        $ObjMuncipios = new Application_Model_DbTable_Municipios();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $this->view->municipios=$ObjMuncipios->fetchAll('estado_id="'.$estado.'"');
        
        }else{
          echo "false";
        }


    }

     public function cargarparroquiaAction()
    {

        $ciudad = $this->_getParam('ciudad');
        
        if ($ciudad) {

        $ObjZonas = new Application_Model_DbTable_Zonas();
        //$ObjInmueble = new Application_Model_DbTable_Inmueble();

        $this->view->parroquias=$ObjZonas->fetchAll('id_ciudad="'.$ciudad.'"');
        
        }else{
          echo "false";
        }


    }


     public function verinfoAction()
    {

        $id = $this->_getParam('id');
        $usuario = $this->_getParam('usuario');
        
        if ($id) {

        $ObjDatos = new Application_Model_DbTable_Datos();

        $ObjInmueble = new Application_Model_DbTable_Inmueble();

        $ObjUsers = new Application_Model_DbTable_Users();

        $this->view->usuario=$ObjUsers->fetchRow('id="'.$usuario.'"');

        //$this->view->inmueble=$ObjInmueble->getInmueble($id);

        $data = array('id_inmueble' => $id );
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjDatos->add($data);

           if ($res) {
             //echo "true";
           }else{
            //echo "false";
           }

        }else{
         // echo "false";
        }



        // $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);

       
    }



    public function solicitarinfoAction()
    {

        $email = $this->_getParam('email');
        $nombre = $this->_getParam('nombre');
        $id = $this->_getParam('id');
        $tlf = $this->_getParam('tlf');
        $mensaje = $this->_getParam('mensaje');
        
        if ($id) {

        $ObjContacto = new Application_Model_DbTable_Contacto();

        $data = array('id_inmueble' => $id,
        'mail' => $email,
        'nombre' => $nombre,
        'telefono' => $tlf,
        'mensaje' => $mensaje
        );
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjContacto->add($data);

           if ($res) {
             echo "true";
           }else{
            echo "false";
           }

        }else{
          echo "false";
        }


        $this->generacorreo($email, $nombre, $mensaje, 'Solicitud de Informacion de Propiedad');

        $ObjInmueble = new Application_Model_DbTable_Inmueble();

        $inm=$ObjInmueble->fetchRow('id="'.$id.'"');

        if (isset($inm['id'])) {
          
          $ObjUsers = new Application_Model_DbTable_Users();

          $usuario=$ObjUsers->fetchRow('id="'.$inm['usuario'].'"');

          if (isset($usuario['id'])) {

            $this->generacorreo($usuario['email'], $nombre, $mensaje.' <br> Telefono:  '.$tlf, 'Solicitud de Informacion de Propiedad');


          }



        }



        // $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);

       
    }

public function uploadAction(){

      $ObjFotos = new Application_Model_DbTable_Fotos();


      $id = $this->_getParam('id');

        $auth = Zend_Auth::getInstance();
        $this->view->auth = $auth;
        $id_user=$auth->getIdentity()->uid;
    
        $output_dir = "assets/images/";

        $fileName='';

            if(isset($_FILES["myfile"]))
            {
                $ret = array();

                $error =$_FILES["myfile"]["error"];
                //You need to handle  both cases
                //If Any browser does not support serializing of multiple files using FormData() 
                if(!is_array($_FILES["myfile"]["name"])) //single file
                {
                    $fileName = $_FILES["myfile"]["name"];


                    $code = md5(uniqid(rand(), true));

                    $nombre=substr($code, 0, 8);


                    $file=$nombre.$fileName;
  

                    move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$file);

                    $img = ImageCreateFromJPEG($output_dir.$file);
  // crear una imagen nueva 
  $thumb = imagecreatetruecolor(300,300);
  // redimensiona la imagen original copiandola en la imagen 
  ImageCopyResized($thumb,$img,0,0,0,0,300,300,ImageSX($img),ImageSY($img));
  // guardar la nueva imagen redimensionada donde indicia $img_nueva 
  ImageJPEG($thumb,$output_dir.'300/'.$file,80);
  ImageDestroy($img);



                    $ret[]= $file;
                }
                else  //Multiple files, file[]
                {
                  $fileCount = count($_FILES["myfile"]["name"]);
                  for($i=0; $i < $fileCount; $i++)
                  {

                    $code = md5(uniqid(rand(), true));

                    $nombre=substr($code, 0, 8);


                    $fileName = $_FILES["myfile"]["name"][$i];

                    $file=$nombre.$fileName;


                    move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$file);

                    $img = ImageCreateFromJPEG($output_dir.$file);

  // crear una imagen nueva 
  $thumb = imagecreatetruecolor(300,300);
  // redimensiona la imagen original copiandola en la imagen 
  ImageCopyResized($thumb,$img,0,0,0,0,300,300,ImageSX($img),ImageSY($img));
  // guardar la nueva imagen redimensionada donde indicia $img_nueva 
  ImageJPEG($thumb,$output_dir.'300/'.$file,80);
  ImageDestroy($img);

                    
                    
                    $ret[]= $file;
                  }
                
                }
                //echo json_encode($ret);
                $data = array('id_solicitud' =>$id , 'foto' =>$file  );

                $ObjFotos->add($data);
                
                $this->view->fotos=$ObjFotos->fetchAll('id_solicitud="'.$id.'"');
            }
            
    }

    public function generarimagenAction(){

        $file = $this->_getParam('urlimagen');

        $output_dir = "assets/images/";

        $ext=end(explode(".", $file));

        

  if ($ext=='jpg'){
    
      $img = ImageCreateFromJPEG($output_dir.$file);
      // crear una imagen nueva 
      $thumb = imagecreatetruecolor(300,300);
      ImageCopyResized($thumb,$img,0,0,0,0,300,300,ImageSX($img),ImageSY($img));
      // guardar la nueva imagen redimensionada donde indicia $img_nueva 
      ImageJPEG($thumb,$output_dir.'300/'.$file,80);
      ImageDestroy($img);

  }elseif($ext=='png'){

      $img = imagecreatefrompng($output_dir.$file);
      // crear una imagen nueva 
      $thumb = imagecreatetruecolor(300,300);
      ImageCopyResized($thumb,$img,0,0,0,0,300,300,ImageSX($img),ImageSY($img));
      // guardar la nueva imagen redimensionada donde indicia $img_nueva 
      imagepng($thumb,$output_dir.'300/'.$file);
      ImageDestroy($img);

  }elseif($ext=='gif'){

      $img = ImageCreateFromGif($output_dir.$file);
      // crear una imagen nueva 
      $thumb = imagecreatetruecolor(300,300);
      ImageCopyResized($thumb,$img,0,0,0,0,300,300,ImageSX($img),ImageSY($img));
      // guardar la nueva imagen redimensionada donde indicia $img_nueva 
      ImageGif($thumb,$output_dir.'300/'.$file);
      ImageDestroy($img);

  }elseif($ext=='bmp'){

      $img = ImageCreateFrompng($output_dir.$file);
      // crear una imagen nueva 
      $thumb = imagecreatetruecolor(300,300);
      ImageCopyResized($thumb,$img,0,0,0,0,300,300,ImageSX($img),ImageSY($img));
      // guardar la nueva imagen redimensionada donde indicia $img_nueva 
      Imagepng($thumb,$output_dir.'300/'.$file);
      ImageDestroy($img);

  }
 

        $this->view->file=$file;
       
    }

     public function principalAction(){

        $id = $this->_getParam('id');

        $id_solicitud = $this->_getParam('id_solicitud');
        
        if ($id) {

        $ObjFotos = new Application_Model_DbTable_Fotos();

        $data = array('posicion' =>'1', );

        

        $ObjFotos->upd($id, $data);

        $this->view->fotos=$ObjFotos->gets($id_solicitud);

        }
       
    }

    public function updateposicionAction(){

        $id = $this->_getParam('id');
        $posicion = $this->_getParam('posicion');
        $id_solicitud = $this->_getParam('id_solicitud');


        
        
        if ($id) {

        $ObjFotos = new Application_Model_DbTable_Fotos();

        $data = array('posicion' =>$posicion, );

        

        $ObjFotos->upd($id, $data);

        
        $this->view->fotos=$ObjFotos->gets($id_solicitud);

        }
       
    }



    public function eliminartagAction()
    {

        $id = $this->_getParam('id');

        $tag = $this->_getParam('tag');
        
        if ($id) {

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
        
           $res=$ObjEtiquetas->deleteEtiqueta($tag);

        }

         $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);

       
    }


    public function agregartagsAction()
    {

        $id = $this->_getParam('id');
        $etiqueta = $this->_getParam('etiqueta');
            if ($id) {

        $ObjEtiquetas = new Application_Model_DbTable_Etiquetas();
        // se envia a la vista todos los registros de usuarios
       
        
        $tags=explode(',', $etiqueta);

        foreach ($tags as $tag) {
            
             $data = array(
            'id_noticia' => $id,
            'descripcion' => trim($tag),
            'estatus' => '1'
            );

           $res=$ObjEtiquetas->addEtiqueta($data);

        }


         $this->view->etiquetas=$ObjEtiquetas->getEtiquetasIdNoticia($id);

        }
    }


/*inicio de funciones noticias */

        public function desactivarnoticiaAction()
    {

        $id = $this->_getParam('id');
            if ($id) {

                 $ObjNoticias = new Application_Model_DbTable_Noticias();
             


              $data = array(
                'estatus' => '0'
                );

              $ObjNoticias->updateNoticia($id, $data);

              $this->view->noticia=$ObjNoticias->getNoticiaUn($id);

        }
    }

      public function activarnoticiaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                 $ObjNoticias = new Application_Model_DbTable_Noticias();
                
             


              $data = array(
                'estatus' => '1'
                );

              $ObjNoticias->updateNoticia($id, $data);

              $this->view->noticia=$ObjNoticias->getNoticiaUn($id);

        }
      
    }

     public function deletenoticiaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjNoticias = new Application_Model_DbTable_Noticias();
                

              $res=$ObjNoticias->del($id);

              echo $res;

        }
      
    }

/*fin de funciones noticias */






    public function desactivarsliderAction()
    {

        $id = $this->_getParam('id');
            if ($id) {

                 $ObjSliders = new Application_Model_DbTable_Sliders();
             


              $data = array(
                'estatus' => '0'
                );

              $ObjSliders->updateSliders($id, $data);

              $this->view->slider=$ObjSliders->getSliders($id);

        }
    }

      public function activarsliderAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                 $ObjSliders = new Application_Model_DbTable_Sliders();
             


              $data = array(
                'estatus' => '1'
                );

              $ObjSliders->updateSliders($id, $data);

              $this->view->slider=$ObjSliders->getSliders($id);

        }
      
    }

     public function deletesliderAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                  $ObjSliders = new Application_Model_DbTable_Sliders();
                
             
                

              $res=$ObjSliders->deleteSliders($id);

              echo $res;

        }
      
    }

     public function deletesvalidadorAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                  $ObjValidador = new Application_Model_DbTable_Validador();
                
              $res=$ObjValidador->del($id);

              echo $res;
        }
      

    }

     public function deletesauditoriaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                  $Obj = new Application_Model_DbTable_Auditoria();
                

              $res=$Obj->del($id);

              echo $res;

        }
      
    }



    

         public function desactivarpaginaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjPaginas = new Application_Model_DbTable_Paginas();
             


              $data = array(
                'estatus' => '0'
                );

              $ObjPaginas->updatePagina($id, $data);

              $this->view->pagina=$ObjPaginas->getPagina($id);

        }
      
    }

      public function activarpaginaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjPaginas = new Application_Model_DbTable_Paginas();
             


              $data = array(
                'estatus' => '1'
                );

              $ObjPaginas->updatePagina($id, $data);

              $this->view->pagina=$ObjPaginas->getPagina($id);

        }
      
    }

     public function deletepaginaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                 $ObjPaginas = new Application_Model_DbTable_Paginas();
                
             
                

              $res=$ObjPaginas->deletePagina($id);

              echo $res;

        }
      
    }



        public function desactivarportafolioAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjPortafolios = new Application_Model_DbTable_Portafolios();
             


              $data = array(
                'estatus' => '0'
                );

              $ObjPortafolios->updatePortafolios($id, $data);

              $this->view->portafolio=$ObjPortafolios->getPortafolios($id);

        }
      
    }

      public function activarportafolioAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                 $ObjPortafolios = new Application_Model_DbTable_Portafolios();
             
              $data = array(
                'estatus' => '1'
                );

              $ObjPortafolios->updatePortafolios($id, $data);

              $this->view->portafolio=$ObjPortafolios->getPortafolios($id);

        }
      
    }

     public function deleteportafolioAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                 $ObjPortafolios = new Application_Model_DbTable_Portafolios();
                
             
                

              $res=$ObjPortafolios->deletePortafolios($id);

              echo $res;

        }
      
    }

    public function desactivarmoduloAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjModulos = new Application_Model_DbTable_Modulos();
             


              $data = array(
                'estatus' => '0'
                );

              $ObjModulos->updateModulos($id, $data);

              $this->view->modulo=$ObjModulos->getModulos($id);

        }
      
    }

      public function activarmoduloAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjModulos = new Application_Model_DbTable_Modulos();
             
              $data = array(
                'estatus' => '1'
                );

              $ObjModulos->updateModulos($id, $data);

              $this->view->modulo=$ObjModulos->getModulos($id);

        }
      
    }

     public function deletemoduloAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

                $ObjModulos = new Application_Model_DbTable_Modulos();
             
                

              $res=$ObjModulos->deleteModulos($id);

              echo $res;

        }
      
    }


public function desactivarserviciosAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

             $objServicios = new Application_Model_DbTable_Servicios();


              $data = array(
                'estatus' => '0'
                );

              $objServicios->upd($id, $data);

              $this->view->servicio=$objServicios->get($id);

        }
      
    }

      public function activarserviciosAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

             $objServicios = new Application_Model_DbTable_Servicios();

              $data = array(
                'estatus' => '1'
                );

              $objServicios->upd($id, $data);

              $this->view->servicio=$objServicios->get($id);

        }
      
    }

     public function deleteserviciosAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

             $objServicios = new Application_Model_DbTable_Servicios();
                

              $res=$objServicios->del($id);

              echo $res;

        }
      
    }


    public function desactivarmarcaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

             $objMarcas = new Application_Model_DbTable_Marcas();

              $data = array(
                'estatus' => '0'
                );

              $objMarcas->upd($id, $data);

              $this->view->marca=$objMarcas->get($id);

        }
      
    }

      public function activarmarcaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

             $objMarcas = new Application_Model_DbTable_Marcas();

              $data = array(
                'estatus' => '1'
                );

              $objMarcas->upd($id, $data);

              $this->view->marca=$objMarcas->get($id);

        }
      
    }

     public function deletemarcaAction()
    {

        $id = $this->_getParam('id');

        if ($id) {

             $objMarcas = new Application_Model_DbTable_Marcas();

              $res=$objMarcas->del($id);

              echo $res;

        }
      
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

      