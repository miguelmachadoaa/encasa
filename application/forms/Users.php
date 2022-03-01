<?php

class Application_Form_Users extends Zend_Form {

    public function init() {
                
        // se asigna nombre y metodo al form
        $this->setName('form_users');
        $this->setMethod('post');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Nombre')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Nombre'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));
        
        $lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Apellido')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Apellido'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Email'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));

        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->setLabel('Telefono')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Telefono'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));


        $cedula = new Zend_Form_Element_Text('cedula');
        $cedula->setLabel('Cedula')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Cedula'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));

                $direccion = new Zend_Form_Element_Text('direccion');
        $direccion->setLabel('Dirección')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Dirección'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));


        $movil = new Zend_Form_Element_Text('movil');
        $movil->setLabel('Movil')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Movil'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Este campo no puede estar vacío',
                    )
                ));
        
        
        $db_states = new Application_Model_DbTable_States();
        $statesArray = $db_states->getStatesArray();
        
        $state = new Zend_Form_Element_Select('state_id');
        $state->addMultiOptions($statesArray)
                ->setLabel('Estado')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Debe seleccionar un Estado',
                    )
                ));
        
        // se crea el campo username
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Nombre de Usuario')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de Usuario'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => 'Este campo no puede estar vacío'
                ))
                ->addValidator('StringLength', FALSE, array(
                    3,100,
                    'messages' => "Este campo debe tener entre %min% y %max% caracteres"
                ))
                ->addValidator('Db_NoRecordExists', FALSE, array(
                    'table' => 'hk_admin_users',
                    'field' => 'username',
                    'messages' => array(
                        'recordFound' => "El usuario '%value%' ya existe, intente con otro",
                    )
                ));
        
        $objRoles = new Application_Model_DbTable_Roles();
        $rolesArray = $objRoles->getRolesArray();
        
        $role_id = new Zend_Form_Element_Select('role_id');
        $role_id->addMultiOptions($rolesArray)
                ->setLabel('Rol')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => array(
                        'isEmpty' => 'Debe seleccionar un Rol',
                    )
                ));
        
        // se crea el campo password
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Contraseña')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Contraseña'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => 'Este campo no puede estar vacío'
                ))
                /*->addValidator('Regex', FALSE, array(
                    '/^(?=^.{6,}$)((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.*$/',
                    'messages' => 'La contraseña debe contener por lo menos una letra minúscula, una letra mayúscula y un número'
                ))*/
                ->addValidator('StringLength', FALSE, array(
                    6,15,
                    'messages' => "Este campo debe tener entre %min% y %max% caracteres"
                ))
                ->addValidator('Identical', FALSE, array(
                    'token' => 'password_conf',
                    'messages' => 'La contraseña y la confirmación no son iguales'
                ));
        
        // se crea el campo password_conf
        $password_conf = new Zend_Form_Element_Password('password_conf');
        $password_conf->setLabel('Repetir Contraseña')
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Repetir Contraseña'
                ))
                ->addValidator('Identical', FALSE, array(
                    'token' => 'password',
                    'messages' => 'La contraseña y la confirmación no son iguales'
                ));
        
        
        // se crea el boton submit
        $submit = new Zend_Form_Element_Submit('btn_submit');
        $submit->setLabel('Guardar')
                ->setAttrib('class', 'btn btn-default');
        
        // se agregan los elementos al form
        $this->addElements(array(
            $name,
            $lastname,
            $email,
            $telefono,
            $cedula,
            $direccion,
            $movil,
            $state,
            $username,
            $role_id,
            $password,
            $password_conf,
            $submit));
        
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
        
    }


}

