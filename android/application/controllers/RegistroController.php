<?php

class RegistroController extends Zend_Controller_Action {

     protected $_auth;
    
    
    public function init() {
         $opt=array('layout'=>'layout');

         Zend_Layout::startMvc($opt);

   
        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');

         $this->_auth = Zend_Auth::getInstance();
    }
    
    public function indexAction() {

        

        $ObjSliders = new Application_Model_DbTable_Sliders();

    	$ObjUsers = new Application_Model_DbTable_Users();
        // se envia a la vista todos los registros de usuarios
        $this->view->sliders = $ObjSliders->fetchAll();

        $ObjPaginas = new Application_Model_DbTable_Paginas();
        // se envia a la vista todos los registros de usuarios
        $this->view->nosotros = $ObjPaginas->fetchRow('grupo="nosotros"');

      

        $this->view->atencion = $ObjPaginas->fetchRow('grupo="atencion"');

        $ObjInmueble= new Application_Model_DbTable_Inmueble();

        $this->view->inmueble = $ObjInmueble->getInmueblesLimitVisible('8');

        $this->view->destacados = $ObjInmueble->getInmueblesLimitDestacado();

        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->servicios = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');

        $objStates = new Application_Model_DbTable_Estados();
        $states = $objStates->fetchAll();
        $this->view->states = $states;

        $objMunicipios = new Application_Model_DbTable_Municipios();
        $municipios = $objMunicipios->fetchAll();
        $this->view->municipios = $municipios;


         $meta = array(
            'titulo' => 'En Casa Venezuela - Inicio', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;

         $this->view->logo='1';



        
    }

    public function postregistroAction() {

         if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
                
                $data = array(
                    'name' => $formData['nombre'],
                    'lastname' => $formData['apellido'],
                    'state_id' => '1',
                    'email' => $formData['email'],
                    'telefono' => '',
                    'movil' => '',
                    'username' => $formData['email'],
                    'password' => md5($formData['clave']),
                        'role_id' => 5,
                    'status' => TRUE
                );
                
                $users = new Application_Model_DbTable_Users();

                $usuario=$users->addUser($data);


                $db = $this->_getParam('db');

                $adapter = new Zend_Auth_Adapter_DbTable(
                        $db, 
                        'hk_admin_users', 
                        'username', 
                        'password', 
                        'MD5(?)'
                );

                $adapter->setIdentity($formData['email']);

                $adapter->setCredential($formData['clave']);

                $result = $this->_auth->authenticate($adapter);

                if ($result->isValid()) {
                    
                    $user = $adapter->getResultRowObject(array('id', 'name', 'lastname', 'username', 'role_id', 'state_id'));
                    
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
                    
                     if ($user->role_id=='5') {

                        $this->_redirect('/areacliente');

                    }else{

                        $this->_redirect('/areaasesor');

                    }

                    return TRUE;

                }
                
            $this->_redirect('/registro');

               
                
            
        }else{

            $this->_redirect('/registro');

        }
        
    }


}
