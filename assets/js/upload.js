
function spais(){ 

    spais=$('#spais').val();  


    window.location.href = "/index/spais/id/"+spais;

    


 }

function principal(id){ 

    id_solicitud=$('#id').val();  

    url="/ajax/principal";

         $.post(url, {id, id_solicitud}, function(data) {

            if (data) {
                
                $(".carga .row").html(data);
                     
            } else {
        
            }

         });


 }

 function cambiarPosicion(id, posicion){ 

  id_solicitud=$('#id').val(); 
     $('#psicionModal').modal('show');
    $('#foto_id').val(id);
    $('#foto_posicion').val(posicion);
    $('#foto_solicitud').val(id_solicitud);
 }

 function updatePosicion(){

    id=$('#foto_id').val();
    posicion=$('#foto_posicion').val();
    id_solicitud=$('#foto_solicitud').val();


       url="/ajax/updateposicion";

         $.post(url, {id, posicion, id_solicitud}, function(data) {

            if (data) {

                $(".carga .row").html(data);
                //$('#etiqueta').val('');
                $('#psicionModal').modal('hide');
               
                
                     
            } else{

              $('#psicionModal').modal('hide');

            }

        
         });



          $('#TipoModal').modal('hide');

 }






function usuariomostrar(id){

       url="/ajax/mostrarusuario";


  $.post(url, {id}, function(data) {

            if (data) {

                $(".usuariobody").html(data);
                //$('#etiqueta').val('');
                $('#usuarioModal').modal('show');
               
                
                     
            } else{

              $('#usuarioModal').modal('hide');

            }

        
         });


}

function enviaralianza(emisor, receptor){

       url="/ajax/enviaralianza";


  $.post(url, {emisor, receptor}, function(data) {

            if (data) {

                $(".respuesta_solicitud").hide().html('<div class="alert alert-success" role="alert">Solicitud Enviada</div>').fadeIn();
              
               
            }

        
         });



}

function confirmaralianza(id){

       url="/ajax/confirmaralianza";


  $.post(url, {id}, function(data) {

            if (data) {

                $("#solicitud"+id+"").fadeOut('slow');
              
               
            }

        
         });



}

function compartirinmueble(id){

       url="/ajax/compartirinmueble";

  $('#compartir_id').val(id);

  $('#CompartirModal').modal('show');


}

function compartirNegocio(){

       url="/ajax/compartirnegocio";

  compartir_id=$('#compartir_id').val();
  comision_negocio=$('#comision_negocio').val();
  condicion_negocio=$('#condicion_negocio').val();


  $.post(url, {compartir_id, comision_negocio, condicion_negocio}, function(data) {

            if (data) {

                $(".compartir"+compartir_id+"").hide().html(data).fadeIn('slow');
  $('#CompartirModal').modal('hide');

                       
            }
        
         });

}


function negocio(id, compartido){

  tipo=$('#negocio'+id+'').val();
  alert(id+tipo);

   url="/ajax/negocio";

   $.post(url, {id, compartido, tipo}, function(data) {

            if (data) {

                //$("#"+id+"").fadeOut(1000);
            
            }
        
         });


}

function borrarimagen(urlimagen, id){

       url="/ajax/borrarimagen";


  $.post(url, {urlimagen}, function(data) {

            if (data) {

                $("#"+id+"").fadeOut(1000);
 // $('#CompartirModal').modal('hide');

                       
            }
        
         });

}

function generarimagen(urlimagen, id){

       url="/ajax/generarimagen";




  $.post(url, {urlimagen}, function(data) {

            if (data) {

                $("#"+id+" .col-sm-1").hide().html(data).fadeIn(500);
 // $('#CompartirModal').modal('hide');

                       
            }
        
         });

}







function solicitar(){

    //alert('dios');


    email=$('#solicitud_email').val();
    tlf=$('#solicitud_tlf').val();
    nombre=$('#solicitud_nombre').val();
    id=$('#id').val();
    mensaje=$('#solicitud_mensaje').val();

     url="/ajax/solicitarinfo";

        
    
      if(email=='' || email==undefined || tlf=='' || tlf==undefined || nombre=='' || nombre==undefined || mensaje=='' || mensaje==undefined ){

         $('.respuesta').html('<p style="color:red;" class="danger">Todos los campos son obligatorios</p>');

      }else{

      

         $.post(url, {email, tlf, nombre, mensaje, id }, function(data) {

            if (data) {

                $('.respuesta').html('<p>Gracias por contactarse con nosotros, a la brevedad nos pondremos en contacto con usted</p>');
                

                $('#email').val('');
                $('#tlf').val('');
                $('#nombre').val('');
                
                $('#mensaje').val('');
               
                
                     
            } else {

                $('.contenido').html(data);
                $('#etiqueta').val('');
        
            }

         });

         }




}


function verinfo(usuario){

 
    id=$('#id').val();

 

     url="/ajax/verinfo";

         $.post(url,{id, usuario }, function(data) {

            if (data) {

                $('#info_contacto').html(data);
               
                     
            } 

         });




}


function cargarZona(){
    ciudad=$('#ciudad').val();

    url="/ajax/cargarparroquia";

         $.post(url, {ciudad}, function(data) {

            if (data) {

                $('#zona').html(data);
                //$('#etiqueta').val('');
               
                
                     
            } else {

                $('#zona').html(data);
                //$('#etiqueta').val('');
        
            }

         });
}





function cargarCiudad(){
    estado=$('#estado').val();

    url="/ajax/cargarciudad";

         $.post(url, {estado}, function(data) {

            if (data) {

                $('#ciudad').html(data);
                //$('#etiqueta').val('');
               
                
                     
            } else {

                $('#ciudad').html(data);
                //$('#etiqueta').val('');
        
            }

        
         });


         url="/ajax/cargarmunicipio";

         $.post(url, {estado}, function(data) {

            if (data) {

                $('#municipio').html(data);
                //$('#etiqueta').val('');
               
                
                     
            } else {

                $('#municipio').html(data);
                //$('#etiqueta').val('');
        
            }

        
         });
}

function buscar(){

    estado=$('#f_estado').val();
    ciudad=$('#f_ciudad').val();
    zona=$('#f_zona').val();
    
    habitacion=$('#habitacion').val();
    bano=$('#bano').val();
    tipo=$('#tipo_propiedad').val();


    location.href='/inmueble/buscar/f_estado/'+estado+'/f_ciudad/'+ciudad+'/f_zona/'+zona+'/f_habitacion/'+habitacion+'/f_bano/'+bano+'/f_tipo/'+tipo;


}



if($('#buscador').length) { 


  $( function() {
    var availableTags = [
      "Amazonas",
      "Anzoátegui",
      "Apure",
      "Aragua",
      "Barinas",
      "Bolívar",
      "Carabobo",
      "Cojedes",
      "Delta Amacuro",
      "Falcón",
      "Guárico",
      "Lara",
      "Mérida",
      "Miranda",
      "Monagas",
      "Nueva Esparta",
      "Portuguesa",
      "Sucre",
      "Táchira",
      "Trujillo",
      "Vargas",
      "Yaracuy",
      "Zulia",
      "Distrito Capital",
      "Dependencias Federales"
    ];
    /*$( "#buscador" ).autocomplete({
      source: availableTags
    });*/

    $( "#buscador" ).autocomplete({
      source: "/ajax/busqueda",
      minLength: 3,
      focus: function( event, ui ) {
        $( "#buscador" ).val( ui.item.descripcion );
        return false;
      },
      select: function( event, ui ) {
        /*log( "Selected: " + ui.item.descripcion + " aka " + ui.item.id );*/
       /* alert("Selected: " + ui.item.descripcion + " aka " + ui.item.id);*/
        $('.filtros').val('');

        $('#'+ui.item.tipo+'').val(ui.item.id);
        $('#buscador').val(ui.item.descripcion);

        return false;

      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li class='opts'>" )
        .append( "<div>" + item.descripcion +  "</div>" )
       
        .appendTo( ul );
    };

     });

   
}


   



   function correo(){
            
            name=$('#nombre').val();
            telefono=$('#telefono').val();
            email=$('#email').val();
            message=$('#mensaje').val();

            //alert(name+email+phone+message);

           

            $.ajax({
            type: "POST",
            data:{name, email, telefono, message},
             url: "http://dptpropiedades.com/assets/correo.php",
            
            complete: function(datos2){
            //alert(id);
            //$("#deleteModal").modal('hide');

            if (datos2.responseText=='false') {
                
                 $('.respuesta').html('<div class="alert alert-danger" role="alert">Hubo un error al enviar su mensaje, porfavor intenta de nuevo.</div>'); 
          
            }else{
                 
                 $('.respuesta').html('<div class="alert alert-success" role="alert">Su mensaje ha sido enviado, en breve nos pondremos en contacto con Usted.</div>'); 

                 $('#name').val('');
            $('#email').val('');
            $('#message').val('');
            }

            
        }
    });



    }


    function registrate(e){
      e.preventDefault();
      $('.modal').modal('hide');

      $('#RegistroModal').modal('show');
    }

function registrar(){
      
      
      email=$('#email').val();
      clave=$('#clave').val();

    url="/ajax/registrarusuario";


      $.post(url, {username, email, clave}, function(data) {

            if (data=='true') {

                //alert(data);

                location.href='administrador/perfil/';
               
                     
            } else {

              alert(data);

              $('#respuesta_registro').html('<span class="label label-danger">Error al intertar registrarlo por favor intente de nuevo</span>');

              $('#RegistroModal').modal('show');
                
        
            }

      
    })

}

function acceder(){
      
      email=$('#acc_email').val();
      clave=$('#acc_clave').val();

    url="/ajax/acceder";

              $('#respuesta_login').html();


      $.post(url, {email, clave}, function(data) {

            if (data=='true') {
                
                location.href='administrador/perfil/';
               
                     
            } else {


              $('#respuesta_login').html('<span class="label label-danger">Usuario o contraseña incorrecta</span>');

              $('#LoginModal').modal('show');
                
        
            }

      
    })

}


function enviarClave(){
      
      email=$('#rec_email').val();
     

    url="/ajax/recuperar";

              $('#respuesta_recuperar').html();


      $.post(url, {email}, function(data) {

            if (data=='true') {
                
                //location.href='administrador/perfil/';
              $('#respuesta_recuperar').html('<span class="label label-danger">Se ha enviado a su Correo Electronico</span>');

               
                     
            } else {


              $('#respuesta_recuperar').html('<span class="label label-danger">Usuario o contraseña incorrecta</span>');

              $('#LoginModal').modal('show');
                
        
            }

      
    })

}


   function login(e){
      e.preventDefault();
      $('.modal').modal('hide');
      $('#LoginModal').modal('show');
    }


    function recuperarClave(e){
      e.preventDefault();
      $('.modal').modal('hide');

      $('#RecuperarModal').modal('show');
    }





    

$(document).ready(function()
{
    
 id=$('#id').val();
 //alert('cargo');

  $("#fileuploader").uploadFile({
  url:"/ajax/upload/id/"+id,
  fileName:"myfile",
  showStatusAfterSuccess:false,
  showAbort:false,
  showDone:false,
    showProgress:false,
    dragDrop:false,

 
  
    onSubmit:function(files)
        {
            
        $(".loader").html("<img title='cargando'  src='/assets/img/loading.gif'>");
        
        },

    onSuccess:function(files,data,xhr)
    {
    $(".carga .row").html(data);
    $(".loader").html("");
          
    },
    onError: function(files,status,errMsg)
        {
           $(".loader").html("");
        }
  
  });



});

if($('#tb_estudiantes').length) { 

  $('#tb_estudiantes').dataTable( {
   // paging: false,
  //  searching: false
} );
  
}



function agregarPropietario(){

  $('#propietarioAddModal').modal('show');
  
}

function savePropietario(){      
      
      id=$('#id').val();  

      nombre_propietario=$('#nombre_propietario').val();  

      apellido_propietario=$('#apellido_propietario').val();  

      fecha_nacimiento_propietario=$('#fecha_nacimiento_propietario').val();  

      telefono_propietario=$('#telefono_propietario').val();  

      email_propietario=$('#email_propietario').val();  

      if (nombre_propietario=='' || nombre_propietario==undefined || apellido_propietario=='' || apellido_propietario==undefined ||  fecha_nacimiento_propietario=='' || fecha_nacimiento_propietario==undefined || telefono_propietario=='' || telefono_propietario==undefined || email_propietario=='' || email_propietario==undefined ) {

        $('#respuesta_modal_add').html('Todos los campos son requeridos ');

      }else{

    url="/ajax/registrarpropietario";

      $.post(url, {nombre_propietario, apellido_propietario, fecha_nacimiento_propietario, telefono_propietario, email_propietario, id}, function(data) {

            if (data) {

              $('#respuesta_propietario').html(data);

              $('#propietarioAddModal').modal('hide');

               $('#nombre_propietario').val('');  

              $('#apellido_propietario').val('');  

              $('#fecha_nacimiento_propietario').val('');  

              $('#telefono_propietario').val('');  

              $('#email_propietario').val('');  

            } else {

              $('#respuesta_propietario').html(data);

               $('#propietarioAddModal').modal('hide'); 

               $('#nombre_propietario').val('');  

              $('#apellido_propietario').val('');  

              $('#fecha_nacimiento_propietario').val('');  

              $('#telefono_propietario').val('');  

              $('#email_propietario').val('');  

            }

          });

    }

  }


function eliminarPropietario(id){      
      
      
      

    url="/ajax/delpropietario";

      $.post(url, {id}, function(data) {

            if (data) {

              $('#respuesta_propietario').html(data);

              

            } else {

              $('#respuesta_propietario').html(data);

               

            }

          });

    

  }
