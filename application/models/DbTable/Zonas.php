<?php

class Application_Model_DbTable_Zonas extends Zend_Db_Table_Abstract {

    protected $_name = 'zonas';
    

  
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
             ->from(array('c'  => 'zonas'))  
             ->join(array('e' => 'ciudades'),'c.id_ciudad = e.id', array('ciudad'))
             
             
              ->where('c.zona LIKE "%'.$desc.'%"');

               $select->setIntegrityCheck(false);

              //echo $select;


        return $this->fetchAll($select);
    }
    
}