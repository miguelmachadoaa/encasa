<?php

class Application_Model_DbTable_Datos extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_datos';
    
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        
        return $row->toArray();
    }

    
    public function add($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function upd($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function del($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

     public function getDatos() {
        
        $select = $this->select()
                ->from(array('e'  => 'hk_datos'),array('id', 'id_inmueble',  'fecha', 'estatus' ))  
                ->join(array('s' => 'hk_inmueble'),'e.id_inmueble = s.id', array('titulo', 'descripcion', 'tipo_inmueble', 'monto_vender'))
                ->order('e.fecha desc');

                
        $select->setIntegrityCheck(false);

        //echo $select;

       // echo $role_id;


        
        $result = $this->fetchAll($select);
        
        return $result;
        
    }
    
}

