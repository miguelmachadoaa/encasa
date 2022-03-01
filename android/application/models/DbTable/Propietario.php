 <?php

class Application_Model_DbTable_Propietario extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_propietario';     

    
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

    public function getPropietarios() {
        
        $select = $this->select()
                        ->from(array('e'  => 'hk_propietario'),array('id','id_propiedad' ,'nombre_propietario','apellido_propietario','telefono_propietario','email_propietario','fecha_nacimiento_propietario'=>'DATE_FORMAT(e.fecha_nacimiento_propietario, "%d/%m/%Y")'))  
                        ->join(array('s' => 'hk_inmueble'),'e.id_propiedad = s.id', array('titulo'));            
     
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    

}