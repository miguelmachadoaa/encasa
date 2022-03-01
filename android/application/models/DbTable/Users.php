<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_admin_users';
    
    public function getUser($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }
    
    public function addUser($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateUser($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }

    public function upd($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteUser($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

    public function del($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
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

    public function getUsuarios() {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_admin_users'))  
            ->join(array('s' => 'hk_roles'),'e.role_id = s.id', array('role'))
            ->join(array('c' => 'hk_states'),'e.state_id = c.id', array('state'));
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function CheckUsuario($email, $pass) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_admin_users'))  
            ->join(array('s' => 'hk_roles'),'e.role_id = s.id', array('role'))           
            ->where('e.email = "'.$email.'"')
            ->where('e.clave = "'.$pass.'"');
         
        
        $select->setIntegrityCheck(false);

        echo $select;

        return $this->fetchRow($select);
        
    }
    
}

