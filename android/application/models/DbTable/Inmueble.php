<?php

class Application_Model_DbTable_Inmueble extends Zend_Db_Table_Abstract {

    protected $_name = 'hk_inmueble';
    

  
    public function get($id) {
        $row = $this->fetchRow('id = ' . (int)$id);
        if (!$row) {
            throw new Exception('No se encontró el registro');
        }
        return $row->toArray();
    }
    public function getInmueblesView() {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
            ->order('e.fecha');                   
     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmueblesAliados($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('solicitud' => 'hk_solicitudes'),'e.usuario = solicitud.receptor', array('emisor', 'receptor'))
            ->join(array('compartido' => 'hk_inmueble_compartido'),'e.id = compartido.id_inmueble', array('comision', 'condiciones', 'id_compartido'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
            ->where('solicitud.emisor="'.$id.'"')
            ->where('solicitud.estatus="confirmado"')
            ->where('e.compartido="si"')
            ->order('e.fecha');                   
     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmueblesNegocio($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            
            ->join(array('negocio' => 'hk_inmueble_negocio'),'e.id = negocio.id_inmueble', array('negocio_tipo'=>'tipo'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
            ->where('negocio.id_usuario="'.$id.'"')
            ->where('negocio.estatus<>"desactivado"')
            ->where('e.compartido="si"')
            ->order('e.fecha');                   
     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmueblesLimitDestacado() {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
                        ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
                        ->where('e.destacado="destacada"')
                        ->order('e.id desc');
                        //->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'));   
     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }


     public function getInmueblesLimitVisible($cantidad) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
                        ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
                        ->where('e.estatus!="eliminada"')
                        ->where('e.estatus!="suspendida"')
                        ->order('e.id desc')
                        ->limit($cantidad)
                        //->join(array('p' => 'hk_professions'),'e.profesion = p.id', array('profesion'=>'profession'));
;                   
     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmueblesLimit($cantidad) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname', 'id_usuario'=>'id', 'imagen_usuario'=>'imagen', 'email_usuario'=>'email'))
                ->order('e.id desc')
                ->limit($cantidad);                   
     
       
            
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

        public function getInmueblesVisible($options = array()) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
              ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
            ->order('e.fecha');                   

if (isset($options['f_estado']) && !empty($options['f_estado'])) {
            $estado = $options['f_estado'];
            $select->where('e.estado = ?', $estado);
        }

 if (isset($options['f_ciudad']) && !empty($options['f_ciudad'])) {
            $ciudad = $options['f_ciudad'];
            $select->where('e.ciudad = ?', $ciudad);
        }  

 if (isset($options['f_municipio']) && !empty($options['f_municipio'])) {
            $municipio = $options['f_municipio'];
            $select->where('e.municipio = ?', $municipio);
        } 

 if (isset($options['f_parroquia']) && !empty($options['f_parroquia'])) {
            $parroquia = $options['f_parroquia'];
            $select->where('e.parroquia = ?', $parroquia);
        } 

if (isset($options['f_tipo']) && !empty($options['f_tipo'])) {
            $tipo = $options['f_tipo'];
            $select->where('e.tipo_inmueble = ?', $tipo);
        }     


        $select->where('e.estatus!="eliminada"');
        $select->where('e.estatus!="suspendida"');

     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);



        return $this->fetchAll($select);
        
    }

     public function getInmueblesUsuario($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
             ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname', 'telefono', 'email', 'movil'));
            $select->where('e.usuario = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmueblesUsuarioDatos($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('d' => 'hk_datos'),'e.id = d.id_inmueble', array('nombre', 'email', 'telefono', 'mensaje', 'fecha_mensaje'=>'fecha'));           
            $select->where('e.usuario = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmueblesUsuarioContacto($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
            ->join(array('d' => 'hk_contacto'),'e.id = d.id_inmueble', array('nombre', 'mail', 'telefono', 'mensaje', 'fecha_mensaje'=>'fecha'));           
            $select->where('e.usuario = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchAll($select);
        
    }

    public function getInmuebles($options = array()) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
             ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname'))
            ->order('e.destacado');                   

if (isset($options['f_estado']) && !empty($options['f_estado'])) {
            $estado = $options['f_estado'];
            $select->where('e.estado = ?', $estado);
        }

 if (isset($options['f_ciudad']) && !empty($options['f_ciudad'])) {
            $ciudad = $options['f_ciudad'];
            $select->where('e.ciudad = ?', $ciudad);
        }  

 if (isset($options['f_zona']) && !empty($options['f_zona'])) {
            $zona = $options['f_zona'];
            $select->where('e.zona = ?', $zona);
        } 

 

if (isset($options['f_tipo']) && !empty($options['f_tipo'])) {
            $tipo = $options['f_tipo'];
            $select->where('e.tipo_inmueble = ?', $tipo);
        }     

            $select->where('e.estatus = ?', 'activo');
     
       
            //$select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        //echo $select;



        return $this->fetchAll($select);
        
    }

    public function getInmueble($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
             ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
           
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname', 'telefono', 'email', 'movil'));           
            $select->where('e.id = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchRow($select);
        
    }

    public function getInmuebleUsuarioIndex($id) {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'))  
             ->join(array('s' => 'estados'),'e.estado = s.id', array('estado', 'id_estado'=>'id'))
            ->join(array('c' => 'zonas'),'e.zona = c.id', array('zona', 'id_zona'=>'id'))
            ->join(array('k' => 'ciudades'),'e.ciudad = k.id', array('ciudad'=>'ciudad', 'id_ciudad'=>'id'))
           
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname', 'telefono', 'email', 'movil'));           
            $select->where('e.usuario = ?', $id);
         
        
        $select->setIntegrityCheck(false);

        return $this->fetchRow($select);
        
    }


     public function getInmuebleUsuario() {
        
        $select = $this->select()
            ->from(array('e'  => 'hk_inmueble'), array('cantidad' => 'count(e.id)' ,'usuario' )) 
            ->join(array('u' => 'hk_admin_users'),'e.usuario = u.id', array('name', 'lastname', 'telefono', 'email', 'movil'))
            ->group('e.usuario');           
         
        
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