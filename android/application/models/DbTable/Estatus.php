<?php

class Application_Model_DbTable_Estatus extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_estatus_pedido';     
    public function getEstatus($id) {
        $select = $this->select()
                        //->from(array('e'  => 'hk_estatus_pedido'),array('id','descripcion' ,'clase')  
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
            ->from(array('e' => 'hk_estatus_pedido'),
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
    
    public function addEstatus($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateEstatus($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteEstatus($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

   
    
}