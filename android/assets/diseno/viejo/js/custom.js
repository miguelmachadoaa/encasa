

function solicitar(){

    //alert('dios');


    email=$('#email').val();
    tlf=$('#tlf').val();
    nombre=$('#nombre').val();
    id=$('#id').val();
    mensaje=$('#mensaje').val();

     url="/ajax/solicitarinfo";

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
      
      username=$('#username').val();
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



