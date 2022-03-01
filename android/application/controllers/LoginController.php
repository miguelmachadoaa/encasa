<?php

class IndexController extends Zend_Controller_Action {
    
    
    public function init() {

    	
         $opt=array('layout'=>'layout');

         Zend_Layout::startMvc($opt);

   
        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');
    }
    
    public function indexAction() {

         $meta = array(
            'titulo' => 'En Casa Venezuela - Login', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;

        
    }

    public function buscarAction() {

        
    }


}
