<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    
    protected function _initConfig() {
        
        $this->bootstrap('db');
        
        $helper = new My_Controller_Helper_Acl();
        $helper->setRoles();
        $helper->setResources();
        $helper->setPrivileges();
        $helper->setAcl();
        
    }
    
    protected function _initPlugins() {
        
        $objFront = Zend_Controller_Front::getInstance();
        $objFront->registerPlugin(new My_Controller_Plugin_Acl());
        
    }
    
}

