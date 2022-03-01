<?php

class Application_Model_DbTable_Modulos extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_modulos';
    
    public function getModulos($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    

   
    
    public function addModulos($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateModulos($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteModulos($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }
    
}

