<?php

class Application_Model_DbTable_Noticias extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_noticia';
    
    public function getNoticia($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }
    
    public function addNoticia($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateNoticia($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteNoticia($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

    public function del($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

     public function getNoticias() {        
        $select = $this->select()
             ->from(array('e'  => 'hk_noticia'),array('id','id_autor' ,'titulo','noticia', 'date_add'=>'DATE_FORMAT(date_add, "%d/%m/%Y")' , 'date_upd'=>'DATE_FORMAT(date_upd, "%d/%m/%Y")','estatus', 'foto'))  
             ->join(array('s' => 'hk_admin_users'),'e.id_autor = s.id', array('name', 'lastname'))
           
              ->order('e.id DESC');
        
        
                
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getNoticiaUn($id) {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_noticia'),array('id','id_autor' ,'titulo','noticia', 'date_add'=>'DATE_FORMAT(date_add, "%d/%m/%Y")' , 'date_upd'=>'DATE_FORMAT(date_upd, "%d/%m/%Y")','estatus', 'foto'))  
             ->join(array('s' => 'hk_admin_users'),'e.id_autor = s.id', array('name', 'lastname'))
             ->where('e.id="'.$id.'"');
        
        $select->setIntegrityCheck(false);

        return $this->fetchRow($select);
        
    }

    public function getNoticiasCantidad($id) {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_noticia'),array('id','id_autor' ,'titulo','noticia', 'date_add'=>'DATE_FORMAT(date_add, "%d/%m/%Y")' , 'date_upd'=>'DATE_FORMAT(date_upd, "%d/%m/%Y")','estatus', 'foto'))  
             ->join(array('s' => 'hk_admin_users'),'e.id_autor = s.id', array('name', 'lastname'))
           ->limit($id)
              ->order('e.date_upd DESC');
        
        
                
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

   
    public function getNoticiasTags($data = array()) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_noticia'),array('id','id_autor' ,'titulo','noticia', 'date_add'=>'DATE_FORMAT(date_add, "%d/%m/%Y")' , 'date_upd'=>'DATE_FORMAT(date_upd, "%d/%m/%Y")','estatus', 'foto'))  
            ->join(array('s' => 'hk_etiquetas'),'e.id = s.id_noticia', array('descripcion'));
           
            foreach ($data as $key) {
              $select->Orwhere('s.descripcion="'.$key.'"');
            }
          
            $select->order('e.id DESC');

             $select->group('e.id');

            $select->limit(10);
        
      
                
        $select->setIntegrityCheck(false);

        //echo $select;

        return $this->fetchAll($select);
        
    }



    public function getNoticiaId($id) {
        
        $select = $this->select()
             ->from(array('e'  => 'hk_noticia'),array('id','id_autor' ,'titulo','noticia', 'date_add'=>'DATE_FORMAT(date_add, "%d/%m/%Y")' , 'date_upd'=>'DATE_FORMAT(date_upd, "%d/%m/%Y")','estatus', 'foto'))  
             ->join(array('s' => 'hk_admin_users'),'e.id_autor = s.id', array('name', 'lastname'))
           
              ->order('e.id DESC')
              ->where('e.id="'.$id.'"');
        
        
                
        $select->setIntegrityCheck(false);

        return $this->fetchRow($select);
        
    }
    
}

