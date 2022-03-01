<?php

class Application_Model_DbTable_Empleados extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_empleados';     
   
    public function getEmpleado($id) {
        $select = $this->select()
                        ->from(array('e'  => 'hk_empleados'),array('id','cedula' ,'nombre','direccion','tlf','estado','fecha_nac'=>'DATE_FORMAT(fecha_nac, "%d/%m/%Y")','email'))  
                        ->where('id = ?', $id);
        //$row = $this->fetchRow('id = ' . (int)$id);

        $row = $this->fetchRow($select);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    public function getCedula(){
        //se crea la consulta 
            $select=$this->select()
            ->from(array('e' => 'hk_Empleados'),
                    array('id', 'cedula'));

            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);


             //se ejecuta la consulta 
            $result = $this->fetchAll($select);

            foreach ($result as $row) {
            $cedula[$row->id] = utf8_encode($row->cedula);
        }
        
        return $cedula;

         //se envia la respuesta
        
    }
    
    public function addEmpleado($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateEmpleado($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteEmpleado($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

    public function getEmpleados() {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_empleados'),array('id','cedula' ,'nombre','email','direccion','tlf','estado', 'fecha_nac'=>'DATE_FORMAT(fecha_nac, "%d/%m/%Y")'))  
             ->join(array('s' => 'hk_states'),'e.estado = s.id', array('estado'=>'state'))
              ->order('e.id DESC');
        
       

                
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }
     public function getMemberId($id) {
        
        $select = $this->select()
                        ->from(array('e'  => 'hk_estudiantes'),array('id','cedula' ,'nombre','apellido','email','direccion','tlf','grado','profesion','estado','ciudad','fecha_nac'=>'DATE_FORMAT(fecha_nac, "%d/%m/%Y")','foto'))  
                        ->join(array('s' => 'hk_states'),'e.estado = s.id', array('estado'=>'state'))
                        ->join(array('c' => 'hk_cities'),'e.ciudad = c.id', array('ciudad'=>'city'))
                        ->join(array('g' => 'hk_grado'),'e.grado = g.id', array('grado'=>'descripcion'))
                        ->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'));
;                   
     
       
            $select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getMembersCount($options = array()) {
        
        $select = $this->select()
                ->from(array('e'  => 'hk_estudiantes'), array('count(*) as total'))
                ->join(array('ec' => 'hk_estudiante_curso'),'e.id = ec.id_estudiante')
                ->join(array('c' => 'hk_cities'),'e.ciudad = c.id', array('ciudad'=>'city'))
                ->join(array('g' => 'hk_grado'),'e.grado = g.id', array('grado'=>'descripcion'))
                ->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'));

        
        if (isset($options['state_id']) && !empty($options['state_id']))
            $select->where ('e.estado = ?', $options['state_id']);
        
        if (isset($options['curso']) && !empty($options['curso']))
            $select->where ('ec.id_curso = ?', $options['curso']);
         $select->setIntegrityCheck(false);
        
        $result = $this->fetchRow($select);
        
        return ($result->total);
        
    }

         public function getMemberCedula($id) {
        
        $select = $this->select()
                        ->from(array('e'  => 'hk_estudiantes'),array('id','cedula' ,'nombre','apellido','email','direccion','tlf','grado','profesion','estado','ciudad','fecha_nac'=>'DATE_FORMAT(fecha_nac, "%d/%m/%Y")','foto'))  
                        ->join(array('s' => 'hk_states'),'e.estado = s.id', array('estado'=>'state'))
                        ->join(array('c' => 'hk_cities'),'e.ciudad = c.id', array('ciudad'=>'city'))
                        ->join(array('g' => 'hk_grado'),'e.grado = g.id', array('grado'=>'descripcion'))
                        ->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'));
;                   
     
       
            $select->where('e.cedula = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchRow($select);
        
    }
	
	 public function getMembersCount2($options = array()) {
        
        $select = $this->select()
                ->from($this, array('count(*) as total'));
        
        if (isset($options['state_id']) && !empty($options['state_id']))
            $select->where ('estado = ?', $options['state_id']);
       
        
        $result = $this->fetchRow($select);
        
        return ($result->total);
        
    }
	
	    public function getMembers2($options = array()) {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_estudiantes'),array('id','cedula' ,'nombre','apellido','email','direccion','tlf','grado','profesion','estado','ciudad','fecha_nac'=>'DATE_FORMAT(fecha_nac, "%d/%m/%Y")','foto'))  
             ->join(array('s' => 'hk_states'),'e.estado = s.id', array('estado'=>'state'))
             ->join(array('c' => 'hk_cities'),'e.ciudad = c.id', array('ciudad'=>'city'))
             ->join(array('g' => 'hk_grado'),'e.grado = g.id', array('grado'=>'descripcion'))
             ->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'))
              ->order('e.id DESC');
        
        if (isset($options['f_grado']) && !empty($options['f_grado'])) {
            $grado = $options['f_grado'];
            $select->where('grado = ?', $grado);
        }
        
        if(isset($options['f_profession']) && !empty($options['f_profession'])) {
            $profesion = $options['f_profession'];
            $select->where('profesion = ?', $profesion);
        }

        if (isset($options['f_state']) && !empty($options['f_state'])) {
            $state = $options['f_state'];
            $select->where('estado = ?', $state);
        }

        if (isset($options['f_city']) && !empty($options['f_city'])) {
            $ciudad = $options['f_city'];
            $select->where('ciudad = ?', $ciudad);
        }
                
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }
    
}