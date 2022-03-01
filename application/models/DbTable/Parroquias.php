<?php

class Application_Model_DbTable_Parroquias extends Zend_Db_Table_Abstract {

    //protected $_name = 'parroquias';
    protected $_name = 'hk_parroquia';
    

  
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
             ->from(array('p'  => 'hk_parroquia'), array('parroquia'=>'nombre', 'id'))  
             ->join(array('m' => 'hk_municipio'),'p.municipio_id = m.id', array('municipio'=>'nombre'))
             ->join(array('e' => 'hk_estado'),'m.estado_id = e.id', array('estado'=>'nombre'))
             
              ->where('p.nombre LIKE "%'.$desc.'%"');

               $select->setIntegrityCheck(false);

              //echo $select;


        return $this->fetchAll($select);
    }
    
}