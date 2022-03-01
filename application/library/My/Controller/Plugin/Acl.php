<?php

class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        $auth = Zend_Auth::getInstance();
        $acl = Zend_Registry::get('acl');
        
        $role = ($auth->hasIdentity()) ? $auth->getIdentity()->role : 'invitado';

        $resource = $request->getControllerName();

        $privilege = $request->getActionName();
        
        if (!$acl->isAllowed($role, $resource, $privilege)) {
            
            $request->setControllerName('Error');
            $request->setActionName('error');
            
        }
        
        if (!$auth->hasIdentity() && !in_array($resource, array('ajax', 'index', 'nosotros', 'contacto', 'servicios', 'portafolio', 'inmueble', 'blog', 'asesores', 'faqs', 'olvide')) && !in_array($privilege, array('index', 'ver', 'buscar', 'tags','codigo', 'reinicar', 'spais'))) {
            
            $request->setControllerName('auth');
            $request->setActionName('login');
            
        }
        
        if ($auth->hasIdentity() && $request->getActionName() === 'login') {
            
            $request->setControllerName('Index');
            $request->setActionName('index');
            
        }
        
        if ($auth->hasIdentity() && in_array($privilege, array('add','edit','del','approve','reject','pending','export', 'index'))) {
            
            /*$params = array(
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'wake'
            );
            $db = Zend_Db::factory('PDO_MYSQL', $params);
            
            $user_id = $auth->getIdentity()->uid;
            $user_ip = $request->getServer('REMOTE_ADDR');
            $data = Zend_Json::encode($request->getParams());
            
            $columnMapping = array(
                'message' => 'message',
                'user_id' => 'user_id',
                'user_ip' => 'user_ip',
                'data' => 'data',
                'timestamp' => 'timestamp'
            );
            
            $writer = new Zend_Log_Writer_Db($db, 'hk_audit_trail', $columnMapping);
            
            $logger = new Zend_Log($writer);
            
            $logger->setEventItem('user_id', $user_id);
            $logger->setEventItem('user_ip', $user_ip);
            $logger->setEventItem('data', $data);
            
            $logger->info($role.':'.$resource .'/'.$privilege);*/
        }
        
    }
    
}
