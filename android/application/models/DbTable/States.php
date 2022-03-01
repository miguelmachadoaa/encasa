<?php

class Application_Model_DbTable_States extends Zend_Db_Table_Abstract
{

    protected $_name = 'hk_states';
    
    public function getStates() {
        
        $select = $this->select()
                ->order('state');
        
        $states = $this->fetchAll($select);
        
        return $states;
    }

    public function getStatesIn($arrayStates = array()) {
        
        $select = $this->select();
        
        if (count($arrayStates) > 0) {
            $select->where('id IN(?)', $arrayStates);
        }
                
        return $this->fetchAll($select);
        
    }

    public function getStatesArray() {
        
        $result = $this->fetchAll();
        
        $states[NULL] = '--seleccione--';
        
        foreach ($result as $row) {
            $states[$row->id] = utf8_encode($row->state);
        }
        
        return $states;
    }
    
    public function getState($state_id) {
        
        $select = $this->select()
                ->where('id = ?', $state_id);
        
        $row = $this->fetchRow($select);
        
        $state = NULL;
        
        if ($row) {
            $state = utf8_encode($row->state);
        }
        
        return $state;
        
    }
    
    public function getStatesJson() {
        
        $select = $this->select()
                ->order('state');
        
        $states = $this->fetchAll($select);
        
        $statesArray = array();
        
        foreach ($states as $state) {
            $statesArray[] = utf8_encode($state->state);
        }
        
        return Zend_Json::encode($statesArray);
    }
    
}

