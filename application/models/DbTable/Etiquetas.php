<?php

class Application_Model_DbTable_Etiquetas extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_etiquetas';
    
    public function getEtiqueta($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }


    public function getEtiquetaGroup() {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_etiquetas'))  
             ->group('e.descripcion');
        

        return $this->fetchAll($select);
        
    }

     public function getEtiquetasIdNoticia($id) {
        $row = $this->fetchAll('id_noticia = ' . (int)$id);
        
        return $row;
    }

     public function getEtiquetaID($id) {
        $row = $this->fetchAll('id_noticia = "' . $id.'"');
        
        return $row;
    }
    
    public function addEtiqueta($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateEtiqueta($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteEtiqueta($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }
    
}

