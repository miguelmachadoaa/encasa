 <?php

class Application_Model_DbTable_Pedidos extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_pedidos';     
    public function getPedido($id) {
        $select = $this->select()
                        ->from(array('e'  => 'hk_pedidos'),array('id','id_cliente' ,'total','fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status')  )
                        ->where('id = ?', $id);
        //$row = $this->fetchRow('id = ' . (int)$id);

        $row = $this->fetchRow($select);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

       public function getPedidoPDF($id) {
        $select = $this->select()
            ->from(array('e'  => 'hk_pedidos'),array('id','id_cliente','id_user' ,'total','fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status')  )
             ->join(array('s' => 'hk_estatus_pedido'),'e.status = s.id', array('descripcion', 'clase', 'id_estatus_pedido'=>'s.id'))
            ->join(array('c' => 'hk_clientes'),'e.id_cliente = c.id', array('id_cliente'=>'c.id','nombre', 'cedula', 'tlf', 'direccion', 'email'))
            ->where('e.id = ?', $id);
        //$row = $this->fetchRow('id = ' . (int)$id);

             $select->setIntegrityCheck(false);

        $row = $this->fetchAll($select);
       
        return $row;
    }

           public function getPedidoPDFun($id) {
        $select = $this->select()
            ->from(array('e'  => 'hk_pedidos'),array('id','id_cliente','id_user' ,'total','fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status')  )
             ->join(array('s' => 'hk_estatus_pedido'),'e.status = s.id', array('descripcion', 'clase', 'id_estatus_pedido'=>'s.id'))
            ->join(array('c' => 'hk_clientes'),'e.id_cliente = c.id', array('id_cliente'=>'c.id','nombre', 'cedula', 'tlf', 'direccion', 'email'))
            ->where('e.id = ?', $id);
        //$row = $this->fetchRow('id = ' . (int)$id);

             $select->setIntegrityCheck(false);

        $row = $this->fetchRow($select);
       
        return $row;
    }

           
    public function masVendidos($inicio, $fin) {
        $select = $this->select()
            ->from(array('e'  => 'hk_pedidos'),array('fecha'=>'DATE_FORMAT(e.fecha, "%d/%m/%Y")','status')  )
             ->join(array('s' => 'hk_detalle_pedido'),'e.id = s.id_pedido', array('cantidad'=>'sum(cantidad)', 'total_ventas'=>'sum(s.total)'))
            ->join(array('p' => 'hk_productos'),'s.id_producto = p.id', array('descripcion','codigo', 'id'))
            ->where('e.status = 2')
            ->where('e.fecha >= "'.$inicio.'"')
            ->where('e.fecha <="'.$fin.'"')
            ->group('p.id');
        //$row = $this->fetchRow('id = ' . (int)$id);

             $select->setIntegrityCheck(false);

             //echo $select;

             

        $row = $this->fetchAll($select);
       
        return $row;
    }

    public function tipodepago($inicio, $fin) {
        $select = $this->select()
            ->from(array('e'  => 'hk_pedidos'),array('fecha'=>'DATE_FORMAT(e.fecha, "%d/%m/%Y")','status')  )
             ->join(array('s' => 'hk_pagos'),'e.id = s.id_pedido', array('cantidad'=>'sum(monto)', 'tipo_pago'))
            ->where('e.status = 2')
            ->where('e.fecha >= "'.$inicio.'"')
            ->where('e.fecha <="'.$fin.'"')
            ->group('s.tipo_pago');
        //$row = $this->fetchRow('id = ' . (int)$id);

             $select->setIntegrityCheck(false);

             //echo $select;

             

        $row = $this->fetchAll($select);
       
        return $row;
    }

     public function bestClientes($inicio, $fin) {
        $select = $this->select()
            ->from(array('e'  => 'hk_pedidos'),array('fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status', 'total'=>'sum(total)'))
            ->join(array('s' => 'hk_empleados'),'e.id_empleado = s.id', array('nombre', 'tlf'))
            ->where('e.status = 2')
            ->where('e.fecha >= "'.$inicio.'"')
            ->where('e.fecha <="'.$fin.'"')
            ->group('s.id');
        //$row = $this->fetchRow('id = ' . (int)$id);

             $select->setIntegrityCheck(false);

             

        $row = $this->fetchAll($select);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row;
    }




    public function getUltimo($id) {
        $select = $this->select()
                        ->from(array('e'  => 'hk_pedidos'),array('id','id_cliente' ,'total','fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status')  )
                        ->order('e.id DESC');
        //$row = $this->fetchRow('id = ' . (int)$id);

        $row = $this->fetchRow($select);
        
        return $row;
    }

    public function getCedula(){
        //se crea la consulta 
            $select=$this->select()
            ->from(array('e' => 'hk_pedidos'),
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
    
    public function addPedido($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updatePedido($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deletePedido($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }



     public function updatePedidoTotal($id) {
       
       $select = $this->select()
            ->from(array('e'  => 'hk_detalle_pedido'),array('total_detalle_pedido'=>'sum(total)')  )
            ->group('id_pedido')
            ->where('id_pedido = "'.$id.'"');
       
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);

        //echo $select;



        $row = $this->fetchRow($select);

        //echo $row->total_detalle_pedido.'id_detalle ';

        $data = array('total' => $row->total_detalle_pedido );


        $rs = $this->updatePedido($id, $data);
        return $rs;
    }


    public function getPedidos($options = array()) {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_pedidos'),array('id','id_cliente','id_user' ,'total','fecha'=>'DATE_FORMAT(fecha, "%d/%m/%Y")','status')  )
             ->join(array('s' => 'hk_estatus_pedido'),'e.status = s.id', array('descripcion', 'clase', 'id_estatus_pedido'=>'id'))
            ->join(array('c' => 'hk_clientes'),'e.id_cliente = c.id', array('nombre'))
            ->join(array('k' => 'hk_empleados'),'e.id_empleado = k.id', array('nombre_empleado'=>'nombre'))
            


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