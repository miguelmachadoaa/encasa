<?php

class Application_Model_DbTable_Municipios extends Zend_Db_Table_Abstract {

    //protected $_name = 'municipios';
    protected $_name = 'hk_municipio';
    

  
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontrĂ³ el registro');
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
             ->from(array('m'  => 'hk_municipio'), array('municipio'=>'nombre', 'id' ))  
             ->join(array('e' => 'hk_estado'),'m.estado_id = e.id', array('estado'=>'nombre'))
             
              ->where('m.nombre LIKE "%'.$desc.'%"');

               $select->setIntegrityCheck(false);

              //echo $select;


        return $this->fetchAll($select);
    }
    
}