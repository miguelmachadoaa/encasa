<?php

class CategoriaController extends Zend_Controller_Action {
    
    protected $_flashMessenger = null;
    
    public function init() {
        
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        
    }

    public function indexAction() {
        
        // se instancia el modelo users
        $ObjCategorias = new Application_Model_DbTable_Categorias();
        // se envia a la vista todos los registros de usuarios
        $this->view->categorias = $ObjCategorias->fetchAll();
        
        
        
        
        
        // se envia a la vista los mensajes de acciones
        $this->view->messages = $this->_flashMessenger->getMessages();
        
       
        
    }

    public function addAction() {
        
        $userForm = new Application_Form_Users();
        $this->view->userForm = $userForm;
        
        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            if ($userForm->isValid($formData)) {
                
                $data = array(
                    'name' => $formData['name'],
                    'lastname' => $formData['lastname'],
                    'state_id' => $formData['state_id'],
                    'username' => $formData['username'],
                    'password' => md5($formData['password']),
                    'created' => date('Y-m-d H:i:s'),
                    'role_id' => $formData['role_id'],
                    'status' => TRUE
                );
                
                $users = new Application_Model_DbTable_Users();
                $users->addUser($data);
                
                $this->_flashMessenger->addMessage(array('success' => 'Se ha registrado un nuevo usuario con éxito!'));
                $this->_redirect('/users');
                
            } else {
                $userForm->populate($formData);
            }
            
        }
        
    }

    public function editAction() {
        
        $id = $this->_getParam('id', 0);
        
        $userForm = new Application_Form_Users();
        $this->view->userForm = $userForm;

        if ($this->getRequest()->isPost()) {
            
            $formData = $this->getRequest()->getPost();
            
            // se agrega validator para campo username
            $userForm->getElement('username')
                    ->addValidator('Db_NoRecordExists', FALSE, array(
                        'table' => 'hk_admin_users', 
                        'field' => 'username', 
                        'exclude' => array('field' => 'id', 'value' => $id),
                        'messages' => "El usuario '%value%' ya existe, intente con otro"
                    ));
            
            // Se elimina validacion de campo password (no requerido)
            $userForm->getElement('password')
                    ->setRequired(FALSE);
            
            if ($userForm->isValid($formData)) {

                $data = array(
                    'name' => $formData['name'],
                    'lastname' => $formData['lastname'],
                    'state_id' => $formData['state_id'],
                    'username' => $formData['username'],
                    'modified' => date('Y-m-d H:i:s'),
                    'role_id' => $formData['role_id'],
                );
                
                $password = trim($formData['password']);
                
                if (!empty($password)) {
                    $data['password'] = md5($password);
                }

                $users = new Application_Model_DbTable_Users();
                $users->updateUser($id, $data);
                
                $this->_flashMessenger->addMessage(array('success' => 'Se ha actualizado el usuario con éxito!'));
                $this->_redirect('/users');
                
            } else {

                $userForm->populate($formData);
                
            }
            
        } else {
            
            if ($id > 0) {
                $users = new Application_Model_DbTable_Users();
                $userForm->populate($users->getUser($id));
            } else {
                throw new Exception('No se encontró el registro');
            }
        }
    }

    public function delAction() {
     
        if ($this->getRequest()->isPost()) {
            
            $request = $this->getRequest()->getPost();
            
            if (isset($request['uid']) && $request['uid'] > 0) {
                
                $uid = $request['uid'];
                
                $objUsers = new Application_Model_DbTable_Users();
                
                if ($objUsers->deleteUser($uid)) {
                    
                    $this->_flashMessenger->addMessage(array('success' => 'Se ha eliminado el usuario con éxito!'));
                    $this->_redirect('/users');
                    
                } else {
                    
                    $this->_flashMessenger->addMessage(array('error' => 'Ocurrió un error eliminando el registro, intente nuevamente.'));
                    $this->_redirect('/users');
                    
                }
                
            } else {
                throw new Exception('No se encontró el registro');
            }
            
        } else {
            $this->_redirect('/users');
        }
        
    }


     public function getallAction(){

         $this->_helper->layout('layout')->disableLayout();
        
        // se instancia el modelo users
        $ObjCategorias = new Application_Model_DbTable_Categorias();
        // se envia a la vista todos los registros de usuarios
        $categorias=$ObjCategorias->fetchAll();

        $json = array();

    

        foreach ($categorias as $row) {
           
           $fila = array(
            'id' => $row->id,
           
            'nombre' => $row->nombre,
            'descripcion' => $row->descripcion
            );

           $json[]=$fila;
           
        }
        
        echo json_encode($json);  
    }

    public function setcategoriaAction(){

         $this->_helper->layout('layout')->disableLayout();




         $nombre = $this->_getParam('nombre');

         $descripcion = $this->_getParam('descripcion');
        
        // se instancia el modelo users
        $ObjCategorias = new Application_Model_DbTable_Categorias();
        // se envia a la vista todos los registros de usuarios
       
           
           $data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'estatus' => '1'
            );

           $res=$ObjCategorias->addCategoria($data);

           if ($res) {
               echo TRUE;
           }else{
            echo false;
           }

        
          
    }

    public function updatecategoriaAction(){

         $this->_helper->layout('layout')->disableLayout();

         $id = $this->_getParam('id');
         $nombre = $this->_getParam('nombre');

         $descripcion = $this->_getParam('descripcion');
        
        // se instancia el modelo users
        $ObjCategorias = new Application_Model_DbTable_Categorias();
        // se envia a la vista todos los registros de usuarios
       
           
           $data = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'estatus' => '1'
            );

           $res=$ObjCategorias->updateCategoria($id, $data);

           if ($res) {
               echo TRUE;
           }else{
            echo false;
           }

        
          
    }

}







