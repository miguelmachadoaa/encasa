<?php

class Application_Model_DbTable_Categorias extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_categoria';
    
    public function getCategoria($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }
    
    public function addCategoria($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateCategoria($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteCategoria($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }
    
}

