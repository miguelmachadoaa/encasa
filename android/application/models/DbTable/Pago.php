 <?php

class Application_Model_DbTable_Pago extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_pagos';     

    
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

    public function getPagado($id) {
       
       $select = $this->select()
            ->from(array('e'  => 'hk_pagos'),array('total_pagado'=>'sum(monto)')  )
            ->group('id_pedido')
            ->where('id_pedido = "'.$id.'"');
       
        //$row = $this->fetchRow('id = ' . (int)$id);

        $select->setIntegrityCheck(false);


        $row = $this->fetchRow($select);
        return $row;
    }

}