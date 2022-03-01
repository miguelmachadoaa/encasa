
(function() {
    "use strict";

    // custom scrollbar

    $("html").niceScroll({styler:"fb",cursorcolor:"#fe4630", cursorwidth: '6', cursorborderradius: '10px', background: '#FFFFFF', spacebarenabled:false, cursorborder: '0',  zindex: '1000'});

    $(".scrollbar1").niceScroll({styler:"fb",cursorcolor:"#fe4630", cursorwidth: '6', cursorborderradius: '0',autohidemode: 'false', background: '#FFFFFF', spacebarenabled:false, cursorborder: '0'});

	
	
    $(".scrollbar1").getNiceScroll();
    if ($('nav.gn-menu-wrapper').hasClass('scrollbar1-collapsed')) {
        $(".scrollbar1").getNiceScroll().hide();
    }

})(jQuery);



$(document).ready(function(){
    /*$("input[type='checkbox'],input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });*/

$("#formRegistro").bootstrapValidator({
    fields: {
        nombre: {
            validators: {
                notEmpty: {
                    message: 'El Nombre es Requerido'
                }
            },
            required: true,
            minlength: 3
        },
        apellido: {
            validators: {
                notEmpty: {
                    message: 'El Apellido es Requerido'
                }
            },
            required: true,
            minlength: 3
        },
        
        email: {
            validators: {
                notEmpty: {
                    message: 'El Email es Requerido'
                },
                regexp: {
                    regexp: /^(\w+)([\-+.\'0-9A-Za-z_]+)*@(\w[\-\w]*\.){1,5}([A-Za-z]){2,6}$/,
                    message: 'El Email no es Válido'
                }
            }
        },
        clave: {
            validators: {
                notEmpty: {
                    message: 'La Contraseña es Requerida'
                },
                different: {
                    field: 'nombre,apellido',
                    message: 'La Contraseña debe ser Distinta al Nombre/Apellido'
                }
            }
        },
        reclave: {
            validators: {
                notEmpty: {
                    message: 'Debe Confirmar la Contraseña'
                },
                identical: {
                    field: 'reclave'
                },
                different: {
                    field: 'nombre,apellido',
                    message: 'La Contraseña debe ser Distinta al Nombre/Apellido'
                }
            }
        }
       
    }
});
});

                     
     
  