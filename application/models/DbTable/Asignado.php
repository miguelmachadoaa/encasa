<?php

class Application_Model_DbTable_Asignado extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_estudiante_curso';
    
      
    public function getAsignado($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }

    public function listAsignado($options = array()){
            
            //se crea la consulta 
            $select=$this->select()
            ->from(array('ec'  => 'hk_estudiante_curso'),array('fecha_cap'=>'DATE_FORMAT(fecha_cap, "%d/%m/%Y")','fecha_ven'=>'DATE_FORMAT(fecha_ven, "%d/%m/%Y")','id','status','codigo')) 
            ->join(array('e' => 'hk_estudiantes'),'ec.id_estudiante = e.id', array('nombre','apellido','cedula','tlf','ciudad','fecha_nac'=>'DATE_FORMAT(fecha_nac, "%d/%m/%Y")'))
            ->join(array('c' => 'hk_cursos'),'ec.id_curso = c.id', array('descripcion'))
			->order(array('ec.status','ec.id'));

            
        if (isset($options['f_curso']) && !empty($options['f_curso'])) {
            $curso = $options['f_curso'];
            $select->where('ec.id_curso = ?', $curso);
        }
        
        if(isset($options['f_status']) && !empty($options['f_status'])) {
            $status = $options['f_status'];
            $select->where('ec.status = ?', $status);
        }

        if (isset($options['f_state']) && !empty($options['f_state'])) {
            $state = $options['f_state'];
            $select->where('e.estado = ?', $state);
        }

        if (isset($options['f_city']) && !empty($options['f_city'])) {
            $ciudad = $options['f_city'];
            $select->where('e.ciudad = ?', $ciudad);
        }




            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);


             //se ejecuta la consulta 
            $result = $this->fetchAll($select);

            //se envia la respuesta
         return $result;
    
    }

        public function getAsignadoUn($id){
            
            //se crea la consulta 
            $select=$this->select()
            ->from(array('ec'  => 'hk_estudiante_curso'),array('fecha_cap'=>'DATE_FORMAT(fecha_cap, "%d/%m/%Y")','fecha_ven'=>'DATE_FORMAT(fecha_ven, "%d/%m/%Y")','id','status','codigo2'=>'codigo')) 
            ->join(array('e' => 'hk_estudiantes'),'ec.id_estudiante = e.id', array('estudiante'=>'cedula','id_estudiante'=>'id'))
            ->join(array('c' => 'hk_cursos'),'ec.id_curso = c.id', array('curso'=>'descripcion','codigo'=>'codigo', 'duracion'=>'duracion'))
            ->where('ec.id = ?', (int)$id);
            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);

                       //se ejecuta la consulta 
            $result = $this->fetchAll($select);

            //se envia la respuesta
         return $result;
    
    }
     public function getAsignadoUser($id){
            
            //se crea la consulta 
            $select=$this->select()
            ->from(array('ec'  => 'hk_estudiante_curso'),array('fecha_cap'=>'DATE_FORMAT(fecha_cap, "%d/%m/%Y")','fecha_ven'=>'DATE_FORMAT(fecha_ven, "%d/%m/%Y")','id','status','codigo'=>'codigo',)) 
            ->join(array('e' => 'hk_estudiantes'),'ec.id_estudiante = e.id', array('estudiante'=>'cedula','id_estudiante'=>'id'))
            ->join(array('c' => 'hk_cursos'),'ec.id_curso = c.id', array('curso'=>'descripcion', 'duracion'=>'duracion'))
            ->where('e.id = ?', (int)$id);
            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);

                       //se ejecuta la consulta 
            $result = $this->fetchAll($select);

            //se envia la respuesta
         return $result;
    
    }

            public function getAsignadoEdit($id){
            
            //se crea la consulta 
            $select=$this->select()
            ->from(array('ec'  => 'hk_estudiante_curso'),array('fecha_cap'=>'DATE_FORMAT(fecha_cap, "%d/%m/%Y")','fecha_ven'=>'DATE_FORMAT(fecha_ven, "%d/%m/%Y")','id','status','codigo')) 
            ->join(array('e' => 'hk_estudiantes'),'ec.id_estudiante = e.id', array('estudiante'=>'e.id'))
            ->join(array('c' => 'hk_cursos'),'ec.id_curso = c.id', array('curso'=>'c.id'))
            ->where('ec.id = ?', (int)$id);
            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);

                       //se ejecuta la consulta 
            $result = $this->fetchAll($select);

            //se envia la respuesta
         return $result->toArray();
    
    }


    
    public function addAsignado($data = array()) {
        $rs = $this->insert($data);
        return $rs;
    }
    
    public function updateAsignado($id, $data = array()) {
        $rs = $this->update($data, 'id = ' . (int)$id);
        return $rs;
    }
    
    public function deleteAsignado($id) {
        $rs = $this->delete('id = ' . (int)$id);
        return $rs;
    }

    public function listAsignadoOut($cedula){
            
            //se crea la consulta 
            $select=$this->select()
            ->from(array('ec'  => 'hk_estudiante_curso'),array('fecha_cap'=>'DATE_FORMAT(fecha_cap, "%d/%m/%Y")','fecha_ven'=>'DATE_FORMAT(fecha_ven, "%d/%m/%Y")','id','status','codigo')) 
            ->join(array('e' => 'hk_estudiantes'),'ec.id_estudiante = e.id', array('nombre','apellido','cedula'))
            ->join(array('c' => 'hk_cursos'),'ec.id_curso = c.id', array('descripcion'));
                
            $select->where('e.cedula = ?', $cedula);

            //se eliminan las restricciones de una sola tabla
             $select->setIntegrityCheck(false);


             //se ejecuta la consulta 
            $result = $this->fetchAll($select);
			
			//$result->toArray();

            //se envia la respuesta
         return $result;
    
    }

    public function vencidos(){
            //se crea la consulta donde se selecciona los registros que vencieron y estan vigentes 
            $hoy = date("Y-m-d");  
            $select=$this->select()

            ->from(array('ec'  => 'hk_estudiante_curso'),array('fecha_cap'=>'DATE_FORMAT(fecha_cap, "%d/%m/%Y")','fecha_ven'=>'DATE_FORMAT(fecha_ven, "%d/%m/%Y")','id','status','codigo'))
            ->where('ec.fecha_ven<?', $hoy)
            ->where('ec.status= ?', "1");      

				//echo $select;

             //se ejecuta la consulta 
            $result = $this->fetchAll($select);
            //se envia la respuesta
         return $result;
    
    }
	
	

    
    
}