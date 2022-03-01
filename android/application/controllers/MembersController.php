<?php

class MembersController extends Zend_Controller_Action
{

    protected $_flashMessenger = null;

    public function init()
    {
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
    }

    public function indexAction()
    {
        
        
        
    }

    public function signupAction()
    {
         $this->_helper->layout('layout')->disableLayout();
		 
		 $objStates = new Application_Model_DbTable_Postmeta();
        $this->view->wp = $objStates;
        
        
        $menuItems = new Application_Model_DbTable_Wp();
		
		
        $this->view->menuItems = $menuItems->getNavMenuItems();
		
		$this->view->menuItems2 = $menuItems->getNavMenuItems();
		
		$this->view->menuItems3 = $menuItems->getNavMenuItems();
        
        $this->view->messages = $this->_flashMessenger->getMessages();

        
    }

   

}








