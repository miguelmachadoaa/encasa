<?php

class Application_Model_DbTable_Detalle extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_detalle_pedido';     
    public function getDetalle($id) {
        $select = $this->select()
                        ->from(array('e'  => 'hk_detalle_pedido'),array('id','id_pedido' ,'id_producto','serial', 'nota', 'cantidad', 'precio', 'total', 'status')  )
                        ->where('id = ?', $id);
        //$row = $this->fetchRow('id = ' . (int)$id);

        $row = $this->fetchRow($select);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }


    public function getDetallePedido($id) {
        $select = $this->select()
                        ->from(array('e'  => 'hk_detalle_pedido')  )
                        ->join(array('s' => 'hk_productos'),'e.id_producto = s.id', array('descripcion'))
                        ->where('id_pedido = ?', $id);
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);

        $row = $this->fetchAll($select);
        
        return $row;
    }


    public function getUltimo() {
        $select = $this->select()
                        ->from(array('e'  => 'hk_detalle_pedido')  )                     
                        ->join(array('s' => 'hk_productos'),'e.id_producto = s.id', array('descripcion'))
                        ->order('e.id DESC');
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);
        $row = $this->fetchRow($select);
        
        return $row;
    }


     public function getUpdateId($id) {
        $select = $this->select()
                        ->from(array('e'  => 'hk_detalle_pedido')  )                     
                        ->join(array('s' => 'hk_productos'),'e.id_producto = s.id', array('descripcion'))
                        ->where('e.id = ?', $id);
                        
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);
        $row = $this->fetchRow($select);
        
        return $row;
    }

    public function getCedula(){
        //se crea la consulta 
            $select=$this->select()
            ->from(array('e' => 'hk_detalle_pedido'),
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
    
    public function addDetalle($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateDetalle($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteDetalle($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

    public function getDetalles($options = array()) {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_pedidos'),array('id','id_cliente','id_user' ,'total','fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status')  )
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