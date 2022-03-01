<?php

class Application_Model_DbTable_Views extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_views';
    
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        
        return $row->toArray();
    }


    public function estadistica($id) {
       $select = $this->select()
            ->from(array('e'  => 'hk_views'), array('dia'=>'DAY(fecha)', 'fecha'=>'DATE_FORMAT(fecha, "%d-%m-%Y")', 'cantidad'=>'count(id)'))  
            //->join(array('s' => 'hk_states'),'e.estado = s.id', array('estado'=>'state'))
            //->join(array('c' => 'hk_cities'),'e.ciudad = c.id', array('ciudad'=>'city'))
           // ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
            //->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'))
            ->group('dia')
            ->where('DATE_SUB( NOW( ) , INTERVAL 30 DAY ) ')
            ->where('id_inmueble="'.$id.'"');

             $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
;         

    }


    public function Allestadistica() {
       $select = $this->select()
            ->from(array('e'  => 'hk_views'), array('dia'=>'DAY(fecha)', 'fecha'=>'DATE_FORMAT(fecha, "%d-%m-%Y")', 'cantidad'=>'count(id)'))  
         
            ->group('dia')
            ->where('DATE_SUB( NOW( ) , INTERVAL 30 DAY ) ')
            ->order('id asc');

             $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
                   
    }

    public function estadisticaId($id) {
       $select = $this->select()
            ->from(array('e'  => 'hk_views'), array('dia'=>'DAY(fecha)', 'fecha'=>'DATE_FORMAT(fecha, "%d-%m-%Y")', 'cantidad'=>'count(id)'))  
         
            ->group('dia')
            ->where('DATE_SUB( NOW( ) , INTERVAL 30 DAY ) ')
            ->where('e.id_inmueble="'.$id.'"');

             $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
                   
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
    
}

