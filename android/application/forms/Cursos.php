<?php

class Application_Form_Cursos extends Zend_Form {

    public function init() {
                
        // se asigna nombre y metodo al form
        $this->setName('form_cursos');
        $this->setMethod('post');
        
                                // se crea el campo cedula



                        // se crea el campo nombre

                $codigo = new Zend_Form_Element_Text('codigo');
        $codigo->setLabel('Código')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Código del Curso '
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));

        $descripcion = new Zend_Form_Element_Text('descripcion');
        $descripcion->setLabel('Descripción')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Descripción'
                ))

                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));
                                // se crea el campo apellido

        $duracion = new Zend_Form_Element_Text('duracion');
        $duracion->setLabel('Duración en Horas')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Duración en Horas'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));
        
        
        // se crea el boton submit
        $submit = new Zend_Form_Element_Submit('btn_submit');
        $submit->setLabel('Guardar')
                ->setAttrib('class', 'btn btn-default');

        $cancel = new Zend_Form_Element_Button('btn_cancel_cursos');
        $cancel->setLabel('Cancelar')
                ->setAttrib('class', 'btn btn-danger');


        
        // se agregan los elementos al form
        $this->addElements(array(
            $codigo,
            $descripcion,
            $duracion,
            $submit,
            $cancel));

        $this->addDisplayGroup(array('btn_submit','btn_cancel_cursos'),'buttons');
        
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

