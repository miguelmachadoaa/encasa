<?php

class Application_Model_DbTable_Cities extends Zend_Db_Table_Abstract
{

    protected $_name = 'hk_cities';

    public function getCitiesArray($state_id = FALSE) {
        
        $select = $this->select()->order('city');
        
        if ($state_id > 0) {
            $select->where('state_id = ?', $state_id);
        }
        
        $result = $this->fetchAll($select);
        
        $cities[NULL] = '-- Seleccione --';
        
        foreach ($result as $row) {
            $cities[$row->id] = utf8_encode($row->city);
        }
        
        return $cities;
    }
    
    public function getCitiesJson($state_id = FALSE) {
        
        $select = $this->select();
        
        if ($state_id > 0) {
            $select->where('state_id = ?', $state_id);
        }
        
        $result = $this->fetchAll($select);
        
        $i = 0;
        
        foreach ($result as $row) {
            $city[$i]['id'] = $row->id;
            $city[$i]['name'] = utf8_encode($row->city);
            $i++;
        }
        
        $cities['cities'] = $city;
        
        return Zend_Json::encode($cities);
    }
    
    public function getCity($city_id) {
        
        $select = $this->select()
                ->where('id = ?', $city_id);
        
        $row = $this->fetchRow($select);
        
        $city = NULL;
        
        if ($row) {
            $city = utf8_encode($row->city);
        }
        
        return $city;
        
    }

        public function getCitiesSelect($state_id = FALSE) {
        
        $select = $this->select()->order('city');
        
        if ($state_id > 0) {
            $select->where('state_id = ?', $state_id);
        }
        
        $cities = $this->fetchAll($select);
        
        return $cities;
    }

      public function getCitiesform() {
        
        $select = $this->select()->order('city');
        
        
        
        $cities = $this->fetchAll($select);
        
        return $cities->toArray();
    }

}

