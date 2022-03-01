<?php

class Application_Model_DbTable_Roles extends Zend_Db_Table_Abstract
{

    protected $_name = 'hk_roles';
    
    public function getRole($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }
    
    public function getRoleName($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->role;
    }
    
    public function getRoleDescription($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->description;
    }
    
    public function getRolesArray() {
        
        $result = $this->fetchAll();
        
        $roles[NULL] = '--seleccione--';
        
        foreach ($result as $row) {
			if($row->id==10){}else{
            $roles[$row->id] = utf8_encode($row->description);
			}
        }
        
        return $roles;
    }

}

