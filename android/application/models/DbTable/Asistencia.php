 <?php

class Application_Model_DbTable_Asistencia extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_asistencia';     

    
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

    public function getAsistencia() {
       
       $select = $this->select()
            ->from(array('e'  => 'hk_asistencia'), array('fecha'=>'DATE_FORMAT(e.fecha, "%d/%m/%Y")', 'id', 'id_empleado'))
            ->join(array('s' => 'hk_empleados'),'e.id_empleado = s.id', array('nombre'));
       
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);


        $row = $this->fetchAll($select);
        return $row;
    }

    public function getAsistenciaDia($inicio, $fin) {

      
       
       $select = $this->select()
            ->from(array('e'  => 'hk_asistencia'), array('fecha'=>'DATE_FORMAT(e.fecha, "%d/%m/%Y")', 'id', 'id_empleado'))
            ->join(array('s' => 'hk_empleados'),'e.id_empleado = s.id', array('nombre'))
            ->where('e.fecha>="'.$inicio.'"')
            ->where('e.fecha<="'.$fin.'"');
       
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);


        $row = $this->fetchAll($select);
        return $row;
    }



}