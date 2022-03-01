<?php

class Application_Model_DbTable_Negocio extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_inmueble_negocio';
    
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        
        return $row->toArray();
    }

    
    public function add($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }

     public function buscar($inmueble, $compartido, $usuario) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble_negocio'))  
            ->where('e.id_compartido="'.$compartido.'"')
            ->where('e.id_inmueble="'.$inmueble.'"')
            ->where('e.id_usuario="'.$usuario.'"');                   
     

        return $this->fetchRow($select);
        
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

