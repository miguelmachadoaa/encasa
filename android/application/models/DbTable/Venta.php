 <?php

class Application_Model_DbTable_Venta extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_venta';     

    
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

    public function getVentas() {
        
        $select = $this->select()
                        ->from(array('e'  => 'hk_venta'),array('id','id_inmueble' ,'id_captador','id_cerrador','monto_venta','comision','fecha'=>'DATE_FORMAT(e.fecha, "%d/%m/%Y")'))  
                        ->join(array('s' => 'hk_inmueble'),'e.id_inmueble = s.id', array('titulo'));            
     
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    

}