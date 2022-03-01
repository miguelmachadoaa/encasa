<?php

class Application_Model_DbTable_Sliders extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_sliders';
    
    public function getSliders($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    

   
    
    public function addSliders($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateSliders($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteSliders($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }
    
}

