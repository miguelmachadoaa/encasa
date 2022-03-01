<?php

class Application_Model_DbTable_Servicios extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_servicios';
    
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
    
}

