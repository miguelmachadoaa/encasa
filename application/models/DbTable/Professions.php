<?php

class Application_Model_DbTable_Professions extends Zend_Db_Table_Abstract
{

    protected $_name = 'hk_professions';
    
    public function getProfessions() {
        
        $select = $this->select()
                ->order('profession');
        
        $rs = $this->fetchAll($select);
        
        return $rs;
        
    }
    
    public function getProfession($id) {
        
        $select = $this->select()
                ->where('id = ?', (int)$id);
        
        $row = $this->fetchRow($select);
        
        if (!$row) {
            return NULL;
        } else {
            return $row->profession;
        }
        
    }
    
}

