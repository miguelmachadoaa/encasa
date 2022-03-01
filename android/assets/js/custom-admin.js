$(document).ready(function(){


     if ( $("#tb_pedidos").length > 0 ) {
    
        $('#tb_pedidos').dataTable();
            
    }


    if ( $("#tb_inmuebles").length > 0 ) {
    
        $('#tb_inmuebles').dataTable();
            
    }

    if ( $("#tb_estudiantes").length > 0 ) {
    
        $('#tb_estudiantes').dataTable();
            
    }





   // if ( $(".fecha") ) {

   //      $('.fecha').datepicker({
   //         format:"dd/mm/yyyy"
   //     });

  //  }

   

   

   


});




function agregarPedido(){
	$('#addCajaModal').modal('show');
}

 function agregardetalle(pedido, producto, cantidad, precio){     

    //alert('hola');

    url="wake/ajax/agregardetalle";

         $.post(url, {pedido, producto, cantidad, precio}, function(data) {

           /* res=JSON.parse(data);*/

            if (data) {
               
                
                $('#contenido_caja').html(data);

                     
            } else {

              
            }
         });

 }


 function cerrarcaja(id){     

    url="wake/ajax/cerrarcaja";

         $.post(url, {id}, function(data) {

           /* res=JSON.parse(data);*/

            if (data) {
               
                
                $('#contenido_caja').html(data);

                     
            } else {

              
            }
         });

 }

  function caja(){     

    //alert('hola');

    url="wake/ajax/caja";

         $.post(url, {}, function(data) {

           /* res=JSON.parse(data);*/

            if (data) {
               
                
                $('#contenido_caja').html(data);

                     
            } else {

              
            }
         });

 }

 function crearCaja(){     

    nombre=$('#nombre_modal').val();

    cliente=$('#cliente').val();

    vendedor=$('#vendedor').val();

    url="wake/ajax/crearcaja";

         $.post(url, {nombre, vendedor, cliente}, function(data) {

            if (data) {
                
                ///alertify.success(res2.contenido).dismissOthers();
                
                $('#contenido_caja').html(data);

               // $('.mensaje').html('<div class="alert alert-success alert-dismissable">Solicitud procesada correctamente</div>');
                
                $('#addCajaModal').modal('hide');
                     
            } else {

                $('.mensaje').html('<div class="alert alert-danger alert-dismissable">Error al procesar solicitud</div>');
                //alertify.error(res2.contenido).dismissOthers(); 

                $('#addCajaModal').modal('hide');
                    
            }

         });

 }


 function detalleCaja(id){     

    //alert('hola');

    url="wake/ajax/detallecaja";

         $.post(url, {id}, function(data) {

           /* res=JSON.parse(data);*/

            if (data) {
                
                ///alertify.success(res2.contenido).dismissOthers();
                
                $('#contenido_caja').html(data);

               /* $('.mensaje').html('<div class="alert alert-success alert-dismissable">Solicitud procesada correctamente</div>');
                
                $('#addCajaModal').modal('hide');*/
                     
            } else {

               /* $('.mensaje').html('<div class="alert alert-danger alert-dismissable">Error al procesar solicitud</div>');
                //alertify.error(res2.contenido).dismissOthers(); 

                $('#addCajaModal').modal('hide');*/
                     
            }




         });

 }

 function eliminardetalle(id, pedido){     

    //alert('hola');

    url="wake/ajax/eliminardetalle";

         $.post(url, {id, pedido}, function(data) {

           /* res=JSON.parse(data);*/

            if (data) {
               
                
                $('#contenido_caja').html(data);

                     
            } else {

              
            }
         });

 }


function pagar(id, monto){     

    $('#id_pedido').val(id);
    $('#monto_modal').val(monto);

    $('#addPagoModal').modal('show');


 }


 function pagarCaja(){     

    
    id=$('#id_pedido').val();
    monto=$('#monto_modal').val();
    tipo_pago=$('#tipo_pago').val();



    url="wake/ajax/pagarcaja";

         $.post(url, {id, monto, tipo_pago}, function(data) {

           /* res=JSON.parse(data);*/

            if (data) {
               
                
                $('#contenido_caja').html(data);

                $('#addPagoModal').modal('hide');

                     
            } else {

              
            }
         });

 }




function desactivarMarca(id){   

    url="/ajax/desactivarmarca";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function activarMarca(id){   

    url="/ajax/activarmarca";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function del(id){
    $('#del_id').val(id);
    $('#deleteModal').modal('show');
 }

  function deleteMarca(){   

    id=$('#del_id').val();

    url="/ajax/deletemarca";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

 }

  function deleteServicios(){   

    id=$('#del_id').val();

    url="/ajax/deleteservicios";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

 }



function desactivarServicio(id){   

    url="/ajax/desactivarservicios";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function activarServicio(id){   

    url="/ajax/activarservicios";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

   function deleteModulo(){   

    id=$('#del_id').val();

    url="/ajax/deletemodulo";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

 }



function desactivarModulo(id){   

    url="/ajax/desactivarmodulo";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function activarModulo(id){   

    url="/ajax/activarmodulo";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }


   function deletePortafolio(){   

    id=$('#del_id').val();

    url="/ajax/deleteportafolio";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

 }



function desactivarPortafolio(id){   

    url="/ajax/desactivarportafolio";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function activarPortafolio(id){   

    url="/ajax/activarportafolio";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }



 



 function deletePagina(){   

    id=$('#del_id').val();

    url="/ajax/deletepagina";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

 }



function desactivarPagina(id){   

    url="/ajax/desactivarpagina";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function activarPagina(id){   

    url="/ajax/activarpagina";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }








 function deleteSlider(){   

    id=$('#del_id').val();

    url="/ajax/deleteslider";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

 }



function desactivarSlider(id){   

    url="/ajax/desactivarslider";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function activarSlider(id){   

    url="/ajax/activarslider";

         $.post(url, {id}, function(data) {

            if (data) {
                
                $('#'+id).html(data);
                     
            } else {
        
            }

         });

 }

 function agregarTags(){

        id=$('#id').val();
        etiqueta=$('#etiqueta').val();

       url="/ajax/agregartags";

         $.post(url, {id, etiqueta}, function(data) {

            if (data) {
                
                $('.contenido').html(data);
                $('#etiqueta').val('');
                     
            } else {
        
            }

         });

 }

 function eliminarTag(tag){   

    id=$('#id').val();

    
    url="/ajax/eliminartag";

         $.post(url, {tag, id}, function(data) {

            if (data) {

                $('.contenido').html(data);
                $('#etiqueta').val('');
               
                
                     
            } else {

                $('.contenido').html(data);
                $('#etiqueta').val('');
        
            }

         });

 }



function cargarParroquia(){
    municipio=$('#municipio').val();

    url="/ajax/cargarparroquia";

         $.post(url, {municipio}, function(data) {

            if (data) {

                $('#parroquia').html(data);
                //$('#etiqueta').val('');
               
                
                     
            } else {

                $('#parroquia').html(data);
                //$('#etiqueta').val('');
        
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


         /*url="/ajax/cargarmunicipio";

         $.post(url, {estado}, function(data) {

            if (data) {

                $('#municipio').html(data);
                //$('#etiqueta').val('');
               
                
                     
            } else {

                $('#municipio').html(data);
                //$('#etiqueta').val('');
        
            }

        
         });*/
}

/* graficos de lineas*/

if ( $("#lineChart").length > 0 ) {
  


Chart.defaults.global.legend = {
        enabled: false
      };

      data=$('#data').html();

      datag=JSON.parse(data);

      //alert(data);

      //alert(datag);

    
      //alert(data);

      // Line chart
      var ctx = document.getElementById("lineChart");
      var lineChart = new Chart(ctx, {
        type: 'line',
        data: datag,
      });

   
    

}

if ( $("#barChart").length > 0 ) {
  


Chart.defaults.global.legend = {
        enabled: false
      };

      data=$('#data').html();
      datag=JSON.parse(data);

      datar=$('#dataregistro').html();
      datarg=JSON.parse(datar);
      //alert(data);

      // Line chart
     
      var ctxr = document.getElementById("barChart");
      var lineChart = new Chart(ctxr, {
        type: 'bar',
        data: datarg,
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    

}




function cambiartipo(id, tipo){     

    

    $('#TipoModal').modal('show');
    $('#del_id').val(id);
    $('#tipo_edit').val(tipo);

 }

 function updateTipo(){

    id=$('#del_id').val();
    tipo=$('#tipo_edit').val();


       url="/ajax/updatetipo";

         $.post(url, {id, tipo}, function(data) {

            if (data) {

                $('.'+id+'tipo').html(data);
                //$('#etiqueta').val('');
               
                
                     
            } else {

                $('.'+id+'tipo').html(data);
                //$('#etiqueta').val('');
        
            }

        
         });



          $('#TipoModal').modal('hide');

 }

 function cambiarEstatus(id, estatus){     

    

    $('#EstatusModal').modal('show');

    $('#del_id').val(id);
    $('#estatus_edit').val(estatus);


 }

  function updateEstatus(){

    id=$('#del_id').val();

    estatus=$('#estatus_edit').val();

    id_captador=$('#id_captador').val();

    id_cerrador=$('#id_cerrador').val();

    monto_venta=$('#monto_venta').val();

    comision=$('#comision_venta').val();


    //alert(id_captador+id_cerrador+monto_venta+comision);


    if (estatus=='vendida' || estatus=='pendiente') {

        $('#datos_adicionales').fadeIn();

        
        if (id_cerrador==undefined || id_captador==undefined || monto_venta==undefined || comision==undefined || id_cerrador=='' || id_captador=='' || monto_venta=='' || comision=='') {

            $('#edit_error_datos').html('<span class="label label-danger">Todos los datos son obligatorios</span>');
        
        }else{

        
        url="/ajax/guardarventa";

         $.post(url, {id, estatus, id_captador, id_cerrador, monto_venta, comision}, function(data) {

            if (data) {

                $('#id_captador').val('');

                $('#id_cerrador').val('');

                $('#monto_venta').val('');

                $('#comision_venta').val('');

            
            } else {

                 $('#id_captador').val('');

                $('#id_cerrador').val('');

                $('#monto_venta').val('');

                $('#comision_venta').val('');

               
            }

        
         });


        url="/ajax/updateestatus";

         $.post(url, {id, estatus}, function(data) {

            if (data) {

                $('.'+id+'estatus').html(data);
                //$('#etiqueta').val('');               
                     
            } else {

                $('.'+id+'estatus').html(data);
                //$('#etiqueta').val('');        
            }

        
         });


        $('#datos_adicionales').fadeOut();

        $('#EstatusModal').modal('hide');



        }


        






    }else{

        url="/ajax/updateestatus";

         $.post(url, {id, estatus}, function(data) {

            if (data) {

                $('.'+id+'estatus').html(data);
                //$('#etiqueta').val('');               
                     
            } else {

                $('.'+id+'estatus').html(data);
                //$('#etiqueta').val('');        
            }

        
         });


        $('#EstatusModal').modal('hide');

    }


       




 }


function borrar(id, modelo){

    $('#del_id').val(id);
    $('#del_modelo').val(modelo);

    $('#deleteModal').modal('show');

}

function eliminar(){

    id=$('#del_id').val();
    modelo=$('#del_modelo').val();

    url="/ajax/eliminar";

     $.post(url, {id, modelo}, function(data) {

            if (data) {
                
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
                     
            } else {
        
            }

         });

}