<?php

class Application_Model_DbTable_Portafolios extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_portafolio';
    
    public function getPortafolios($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    

   
    
    public function addPortafolios($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updatePortafolios($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deletePortafolios($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }
    
}

