<?php

class Application_Model_DbTable_Estados extends Zend_Db_Table_Abstract {

    protected $_name = 'estados';
    
    

  
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
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

    public function like($desc) {
        $select = $this->select()
             ->from(array('e'  => 'estados') ,array('estado', 'id'))  
             
              ->where('e.estado LIKE "%'.$desc.'%"');

               $select->setIntegrityCheck(false);

              //echo $select;


        return $this->fetchAll($select);
    }
    
}