<?php

class Application_Model_DbTable_Solicitud extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_solicitudes';
    
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

    public function getSolicitudesUsuario($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_solicitudes'))  
            ->join(array('s' => 'hk_admin_users'),'e.emisor = s.id', array('name', 'lastname', 'email', 'telefono', 'movil', 'imagen', 'username'))
            ->join(array('c' => 'hk_states'),'s.state_id = c.id', array('state'))   
            ->where('e.receptor = ?', $id)
            ->where('e.estatus = "Pendiente"');
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getUsuario($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_admin_users'))  
            ->join(array('s' => 'hk_roles'),'e.role_id = s.id', array('role'))
            ->join(array('c' => 'hk_states'),'e.state_id = c.id', array('state'))   
            ->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchRow($select);
        
    }
    
}

