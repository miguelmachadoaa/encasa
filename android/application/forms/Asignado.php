<?php

class Application_Form_Asignado extends Zend_Form {

    public function init() {
                
        // se asigna nombre y metodo al form
        $this->setName('form_asignado');
        $this->setMethod('post');
        
         $db_states = new Application_Model_DbTable_Estudiantes();
        $cedulaArray = $db_states->getCedula();
        
         $codigo = new Zend_Form_Element_Text('codigo');
			$codigo->setLabel('Codigo Certificación')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este Campo no Puede estar Vacio',
                    )
                ));   
		
		
		$estudiante = new Zend_Form_Element_Text('estudiante');
        $estudiante->setLabel('Estudiante')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este Campo no Puede estar Vacio',
                    )
                ));    


         $db_cursos = new Application_Model_DbTable_Cursos();
        $cursoArray = $db_cursos->getCursoArray();
        
        $curso = new Zend_Form_Element_Select('curso');
        $curso->addMultiOptions($cursoArray)
                ->setLabel('Curso')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Debe seleccionar un Curso',
                    )
                ));   

             $fecha_cap = new Zend_Form_Element_Text('fecha_cap');
        $fecha_cap->setLabel('Fecha de Certificación')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control fecha',
                    'placeholder' => 'Fecha de Certificación'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Debe Seleccionar una Fecha',
                    )
                ));     

        $fecha_ven = new Zend_Form_Element_Text('fecha_ven');
        $fecha_ven->setLabel('Fecha de Vencimiento ')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control fecha',
                    'placeholder' => 'Fecha de Vencimiento'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Debe Seleccionar una Fecha',
                    )
                ));        



                        
        
        // se crea el boton submit
        $submit = new Zend_Form_Element_Submit('btn_submit');
        $submit->setLabel('Guardar')
                ->setAttrib('class', 'btn btn-default');

        $cancel = new Zend_Form_Element_Button('btn_cancel_cert');
        $cancel->setLabel('Cancelar')
                ->setAttrib('class', 'btn btn-danger');
        
        // se agregan los elementos al form
        $this->addElements(array(
            $codigo,
			$estudiante,
            $curso,
            $fecha_cap,
            $fecha_ven,
            $submit,
            $cancel
         ));
        
        $this->addDisplayGroup(array('btn_submit','btn_cancel_cert'),'buttons');

        // se limpian decorators
        $this->clearDecorators();
        // se agregan decorators al form
        $this->addDecorator('FormElements')
                ->addDecorator('HtmlTag', array('tag' => 'div'))
                ->addDecorator('Form');
        
        // indica cuales elementos (decorators) se mostraran en el form
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            'Description',
            'Label',

            array('HtmlTag', array('tag' => 'div', 'class' => 'form-group'))
        ));
        
        // para el boton submit no es necesario el label
        $submit->setDecorators(array('ViewHelper'));
         $cancel->setDecorators(array('ViewHelper'));
        
    }


}

