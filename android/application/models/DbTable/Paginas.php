<?php

class Application_Model_DbTable_Paginas extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_pagina';
    
    public function getPagina($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }
    
    public function addPagina($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updatePagina($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deletePagina($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

     public function getPaginas() {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_noticia'),array('id','id_autor' ,'titulo','noticia', 'date_add'=>'DATE_FORMAT(date_add, "%d/%m/%Y")' , 'date_upd'=>'DATE_FORMAT(date_upd, "%d/%m/%Y")','estatus', 'foto'))  
             ->join(array('s' => 'hk_admin_users'),'e.id_autor = s.id', array('name', 'lastname'))
           
              ->order('e.id DESC');
        
        
                
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

   
 
    
}

