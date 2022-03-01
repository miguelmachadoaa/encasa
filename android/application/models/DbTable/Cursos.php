<?php

class Application_Model_DbTable_Cursos extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_cursos';
    

  
    public function getCurso($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    public function getCursoArray(){
        //se crea la consulta 
            $select=$this->select()
            ->from(array('c' => 'hk_cursos'),
                    array('id', 'descripcion'));

            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);


             //se ejecuta la consulta 
            $result = $this->fetchAll($select);

            foreach ($result as $row) {
            $curso[$row->id] = utf8_encode($row->descripcion);
        }
        
        return $curso;

    }

        public function getCursoInfo($city_id) {
        
        $select = $this->select()
                ->where('id = ?', $city_id);
        
        $row = $this->fetchRow($select);
        
        $curso = NULL;
        
        if ($row) {
            $curso = utf8_encode($row->descripcion);
        }
        
        return $curso;
        
    }
    
    public function addCurso($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateCurso($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteCurso($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }
    
}