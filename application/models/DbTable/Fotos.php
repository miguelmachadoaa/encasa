<?php

class Application_Model_DbTable_Fotos extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_fotos';
    

  
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    public function gets($id) {

        $select = $this->select()
        ->from(array('e'  => 'hk_fotos')) 
            ->order('e.posicion asc')
            ->where('id_solicitud="'.$id.'"');


        return $this->fetchAll($select);
    }

    public function getsSolicitudUna($id) {
        $row = $this->fetchRow('id_solicitud = "' .$id.'"');
        
        return $row;
    }

    public function updSolicitud($id) {

        $data = array('posicion' =>'0', );

        $rs = $this->update($data, 'id_solicitud = "' .$id.'"');
        return $rs;
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