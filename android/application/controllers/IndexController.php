<?php

class IndexController extends Zend_Controller_Action {
    
    
    public function init() {
         $opt=array('layout'=>'layout');

         Zend_Layout::startMvc($opt);

   
        $Obj= new Application_Model_DbTable_Identidad();
        
        $this->view->identidad=$Obj->get('1');
    }
    
    public function indexAction() {

        

    	$ObjSliders = new Application_Model_DbTable_Sliders();
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



        
    }

    public function buscarAction() {

       
        
    }


}
