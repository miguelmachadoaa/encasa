<?php

class Application_Form_Login extends Zend_Form {

    public function init() {

        $this->setName('form_login');
        $this->setMethod('post');
        
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Usuario')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Nombre de Usuario',
                    'autofocus' => TRUE
                ))
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => 'Este campo no puede estar vacío'
                ));
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Contraseña')
                ->setRequired(TRUE)
                ->setAttribs(array(
                    'class' => 'form-control',
                    'placeholder' => 'Contraseña'
                ))
                ->addValidator('NotEmpty', FALSE, array(
                    'messages' => 'Este campo no puede estar vacío'
                ));
        
        $submit = new Zend_Form_Element_Submit('btn_submit');
        $submit->setLabel('Iniciar Sesión')
                ->setIgnore(TRUE)
                ->setAttrib('class', 'btn btn-lg btn-primary btn-block');
        
        $this->addElements(array(
            $username,
            $password,
            $submit));
        
        $this->clearDecorators();
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-signin')),
            'Form'
        ));
        
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-group'))
        ));
        
        $submit->setDecorators(array('ViewHelper'));
        
    }

}
