<?php

class NosotrosController extends Zend_Controller_Action {
    
    
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
        $this->view->nosotros = $ObjPaginas->fetchAll('grupo="nosotros"');
        $this->view->objetivos = $ObjPaginas->fetchAll('grupo="objetivos"');

        

        $ObjMarcas= new Application_Model_DbTable_Marcas();

        $this->view->marcas = $ObjMarcas->fetchAll('estatus=1');

        $ObjServicios= new Application_Model_DbTable_Servicios();

        $this->view->avaluos = $ObjServicios->fetchAll('estatus=1');

        $ObjModulos= new Application_Model_DbTable_Modulos();

      
        $this->view->modulos = $ObjModulos->fetchAll('estatus=1');

         $meta = array(
            'titulo' => 'Nosotros -En Casa Plus', 
            'descripcion' => '', 
            'imagen' => '',
            'url'=>''
            );

         $this->view->meta=$meta;
        
    }


}
