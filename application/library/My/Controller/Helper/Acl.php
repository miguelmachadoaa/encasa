<?php

class My_Controller_Helper_Acl {
    
    public $acl;
    
    protected $_objRoles;
    protected $_objResources;
    protected $_objPrivileges;
    protected $_objAccess;

    public function __construct() {
        
        $this->acl = new Zend_Acl();
        $this->_objRoles = new Application_Model_DbTable_Roles();
        $this->_objResources = new Application_Model_DbTable_Resources();
        $this->_objPrivileges = new Application_Model_DbTable_Privileges();
        $this->_objAccess = new Application_Model_DbTable_Access();
        
    }
    
    public function setRoles() {
        
        // en este caso los roles son: administrador y secretario
        $roles = $this->_objRoles->fetchAll();
        
        foreach ($roles as $role) {
            $this->acl->addRole(new Zend_Acl_Role($role->role));
        }
		/*$this->acl->addRole(new Zend_Acl_Role('secretario'));
		 $this->acl->addRole(new Zend_Acl_Role('administrador'));
		 $this->acl->addRole(new Zend_Acl_Role('superadmin'),'administrador');*/
        
        // invitado para los usuarios que se van a registrar
        $this->acl->addRole('invitado');
		
        
    }
    
    public function setResources() {
        
        // Recursos generales
        $this->acl->add(new Zend_Acl_Resource('error'));
        $this->acl->add(new Zend_Acl_Resource('ajax'));
        $this->acl->add(new Zend_Acl_Resource('auth'));
        
        // en este caso los recursos son los controladores
        $resources = $this->_objResources->fetchAll();
        
        foreach ($resources as $resource) {
            $this->acl->add(new Zend_Acl_Resource($resource->resource));
        }
        
    }
    
    public function setPrivileges() {
        
        $roles = $this->_objRoles->fetchAll();
        $resources = $this->_objResources->fetchAll();
				

		//$this->acl->allow('superadmin');
        
        foreach ($roles as $role) {
            
            #if ($role->role == 'administrador' or $role->role == 'superadmin' ) {
            if ($role->role == 'superadmin' ) {
                
                $this->acl->allow($role->role);
                
            } else {
                
                foreach ($resources as $resource) {
                    
                    $privileges = array();
                    
                    $access = $this->_objAccess->getAccess($role->id, $resource->id);
                    
                    if (count($access) > 0) {
                        
                        foreach ($access as $ac) {
                            
                            $privilege = $this->_objPrivileges->fetchRow('id = ' . $ac->privilege_id);
                            
                            $privileges[] = $privilege->privilege;
                            
                        }
                        
                        $this->acl->allow($role->role, $resource->resource, $privileges);
                        
                    }
                }
            }
        }
        
        // permisos generales
        $this->acl->allow(NULL, array('error', 'ajax', 'auth'));
        $this->acl->allow(NULL, 'index', 'index');
        $this->acl->allow(NULL, 'index', 'spais');
        $this->acl->allow(NULL, 'asesores', 'index');
        $this->acl->allow(NULL, 'index', 'buscar');
        $this->acl->allow(NULL, 'nosotros', 'index');
        $this->acl->allow(NULL, 'contacto', 'index');
        $this->acl->allow(NULL, 'servicios', 'index');
        $this->acl->allow(NULL, 'portafolio', 'index');
        $this->acl->allow(NULL, 'inmueble', 'buscar');
        $this->acl->allow(NULL, 'inmueble', 'ver');
        $this->acl->allow(NULL, 'inmueble', 'detalle');
        //$this->acl->allow(NULL, 'administrador', 'ver');
        $this->acl->allow(NULL, 'sitio', 'ver');
        $this->acl->allow(NULL, 'sitio', 'inmueble');
        $this->acl->allow(NULL, 'blog', 'ver');
        $this->acl->allow(NULL, 'blog', 'index');
        $this->acl->allow(NULL, 'blog', 'tags');
        $this->acl->allow(NULL, 'directorio', 'index');
        $this->acl->allow(NULL, 'terminos', 'index');
        $this->acl->allow(NULL, 'faqs', 'index');

        $this->acl->allow(NULL, 'olvide', 'index');
        $this->acl->allow(NULL, 'olvide', 'codigo');
        $this->acl->allow(NULL, 'olvide', 'reiniciar');
        $this->acl->allow(NULL, 'auth', 'olvide');

        $this->acl->allow(NULL, 'marcas', 'index');
		#$this->acl->allow(NULL, 'certificados', 'detail');
       # $this->acl->allow(NULL, 'index', 'index');
       #  $this->acl->allow(NULL, 'noticia', 'getcantidad');
       #  $this->acl->allow(NULL, 'modulo', 'getall');
       #   $this->acl->allow(NULL, 'sliders', 'getall');
       #   $this->acl->allow(NULL, 'portafolio', 'getall');
    }
    
    public function setAcl() {
        
        Zend_Registry::set('acl', $this->acl);
        
    }
    
}

