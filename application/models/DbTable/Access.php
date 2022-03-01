<?php

class Application_Model_DbTable_Access extends Zend_Db_Table_Abstract
{

    protected $_name = 'hk_access';
    
    public function getAccess($role_id, $resource_id) {
        
        $select = $this->select()
                ->where('role_id = ?', $role_id)
                ->where('resource_id = ?', $resource_id);
        
        $result = $this->fetchAll($select);
        
        return $result;
        
    }

    public function getAccessControl($role_id) {
        
        $select = $this->select()
                ->from(array('e'  => 'hk_access'),array('id'))  
                ->join(array('s' => 'hk_resources'),'e.resource_id = s.id', array('resource'))
                ->join(array('c' => 'hk_privileges'),'e.privilege_id = c.id', array('privilege'))
                ->where('e.role_id = "'.$role_id.'"');

                
        $select->setIntegrityCheck(false);

        //echo $select;

       // echo $role_id;


        
        $result = $this->fetchAll($select);
        
        return $result;
        
    }




}

