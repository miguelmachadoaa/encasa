<?php

class Application_Model_DbTable_Grado extends Zend_Db_Table_Abstract
{

    protected $_name = 'hk_grado';
    
    public function getGrado() {
        
        $select = $this->select()->order('descripcion');
        
        
        $result = $this->fetchAll($select);
        
        $grado[NULL] = '-- Seleccione --';
        
        foreach ($result as $row) {
            $grado[$row->id] = utf8_encode($row->descripcion);
        }
        
        return $grado;
    }

  

    public function getGradoArray() {
        
        $result = $this->fetchAll();
        
        $grado[NULL] = '--seleccione--';
        
        foreach ($result as $row) {
            $grado[$row->id] = utf8_encode($row->descripcion);
        }
        
        return $grado;
    }
    
    public function getGradoUn($grado_id) {
        
        $select = $this->select()
                ->where('id = ?', $grado_id);
        
        $row = $this->fetchRow($select);
        
        $grado = NULL;
        
        if ($row) {
            $grado = utf8_encode($row->descripcion);
        }
        
        return $grado;
        
    }
    
    public function getGradoJson() {
        
        $select = $this->select()
                ->order('id');
        
        $states = $this->fetchAll($select);
        
        $statesArray = array();
        
        foreach ($states as $state) {
            $statesArray[] = utf8_encode($state->desripcion);
        }
        
        return Zend_Json::encode($statesArray);
    }
    
}

