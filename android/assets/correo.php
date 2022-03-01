<?php 

 

function genera_correo($nombre, $phone, $message){

$cuerpo='
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
      <title>DPT Propiedades</title>
      
      <style type="text/css">
         /* Client-specific Styles */
         #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
         body{font-family: "Open Sans", sans-serif; width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/
         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
         a img {border:none;}
         .image_fix {display:block;}
         p {margin: 0px 0px !important;}
         table td {border-collapse: collapse;}
         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
         a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}
         /*STYLES*/
         table[class=full] { width: 100%; clear: both; }
         /*IPAD STYLES*/
         @media only screen and (max-width: 640px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important;
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
         img[class=banner] {width: 440px!important;height:220px!important;}
         img[class=colimg2] {width: 440px!important;height:220px!important;}
         
         
         }
         /*IPHONE STYLES*/
         @media only screen and (max-width: 480px) {
         a[href^="tel"], a[href^="sms"] {
         text-decoration: none;
         color: #0a8cce; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
         text-decoration: default;
         color: #0a8cce !important; 
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
         img[class=banner] {width: 280px!important;height:140px!important;}
         img[class=colimg2] {width: 280px!important;height:140px!important;}
         td[class=mobile-hide]{display:none!important;}
         td[class="padding-bottom25"]{padding-bottom:25px!important;}
        
         }
      </style>
   </head>
   <body>
<!-- Start of preheader -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" >
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10"></td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="100" align="left" border="0" cellpadding="0" cellspacing="0">
                                       <tbody>
                                          <tr>
                                             <td align="left" valign="middle" style="font-family: \'Open Sans\', sans-serif; font-size: 14px;color: #666666" st-content="viewonline" class="mobile-hide">
                                                
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <table width="100" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <tr>
                                            <!-- <td width="30" height="30" align="right">
                                                <div class="imgpop">
                                                   <a target="_blank" href="https://facebook.com/decohouse">
                                                   <img src="http://localhost/decohouse.com.ve/assets/images/redes/facebook.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             
                                             <td width="30" height="30" align="center">
                                                <div class="imgpop">
                                                   <a target="_blank" href="https://twitter.com/decohouse">
                                                   <img src="http://localhost/decohouse.com.ve/assets/images/redes/twitter.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td>
                                             <td width="30" height="30" align="center">
                                                <div class="imgpop">
                                                   <a  target="_blank" href="https://twitter.com/decohouse">
                                                   <img src="http://localhost/decohouse.com.ve/assets/images/redes/insta.png" alt="" border="0" width="30" height="30" style="display:block; border:none; outline:none; text-decoration:none;">
                                                   </a>
                                                </div>
                                             </td> -->
                                             
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="100%" height="10"></td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of preheader -->       
<!-- Start of header -->

<!-- End of Header -->
<!-- Start of main-banner -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="banner">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                           <tbody>
                              <tr>
                                 <!-- start of image -->
                                 <td align="center" st-image="banner-image">
                                    <div class="imgpop">
                                       <a target="_blank" href="dptpropiedades.com"><img  border="0" height="200" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" src="http://dptpropiedades.com/assets/img/logo.png" class="banner"></a>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <!-- end of image -->
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of main-banner --> 
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="20" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- Start Full Text -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 30px; color: #146eb4      ; text-align:center; line-height: 30px;" st-title="fulltext-heading">
                                                Hola '.$nombre.' 

                                             </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style="font-family: \'Open Sans\', sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
                                               Hemos Recibido la siguiente consulta: <br>
                                               '.$message.'<br>
                                               Telefono: '.$phone.'<br>
                                               <br>
                                               Pronto nos pondremos en contacto con usted, Muchas Gracias por su interes.

                                             </td>
                                          </tr>
                                          
                                          <!-- End of content -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                             
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of full text -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->   
<!-- 3 Start of Columns -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <tr>
                                 <td>
                                    <!-- col 1 -->
                                    <table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- image 2 -->
                                          <tr>
                                             <td width="100%" align="center" class="devicewidth">
                                                <img src="http://dptpropiedades.com/assets/img/1e1a6a704650b36b62fd46ea97c96cc5.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                          <!-- end of image2 -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->  
                                                <table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                   <tbody>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- title2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #146eb4      ; text-align:center; line-height: 24px;" st-title="3col-title1">
                                                            <a href="http://dptpropiedades.com/">  PROPIEDADES EXCLUSIVAS </a>
                                                         </td>
                                                      </tr>
                                                      <!-- end of title2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- content2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content1">
                                                            Nuestro portal cuenta con la mejor selecci�n de inmuebles en Caracas, Maracay, Valencia y muchas otras ciudades
                                                         </td>
                                                      </tr>
                                                      <!-- end of content2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                     
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- spacing -->
                                    <table width="20" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
                                       <tbody>
                                          <tr>
                                             <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of spacing -->
                                    <!-- col 2 -->
                                    <table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- image 2 -->
                                          <tr>
                                             <td width="100%" align="center" class="devicewidth">
                                                <img src="http://dptpropiedades.com/assets/img/68ed7348097ca487e33bc9d90a06c587.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                          <!-- end of image2 -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->  
                                                <table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                   <tbody>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- title2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-weight: 700; font-size: 18px; color: #146eb4      ; text-align:center; line-height: 24px;" st-title="3col-title2">
                                                            EL MEJOR PRECIO DEL MERCADO
                                                         </td>
                                                      </tr>
                                                      <!-- end of title2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- content2 -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content2">
                                                            Una vez que encuentres el inmueble adecuado, DTP Propiedades te proporcionar� la informacion de contacto necesaria para que te comuniques con el agente inmobiliario, ya sea v�a email o por telefono
                                                         </td>
                                                      </tr>
                                                      <!-- end of content2 -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- /Spacing -->
                                                     
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                    <!-- end of col 2 -->
                                    <!-- spacing -->
                                    <table width="1" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
                                       <tbody>
                                          <tr>
                                             <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of spacing -->
                                    <!-- col 3 -->
                                    <table width="186" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                                       <tbody>
                                          <!-- image3 -->
                                          <tr>
                                             <td width="100%" align="center" class="devicewidth">
                                                <img src="http://dptpropiedades.com/assets/img/be9e67cf72ab499a2659fec3e94ac977.jpg" alt="" border="0" width="100" height="100" style="display:block; border:none; outline:none; text-decoration:none;">
                                             </td>
                                          </tr>
                                          <!-- end of image3 -->
                                          <tr>
                                             <td>
                                                <!-- start of text content table -->  
                                                <table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
                                                   <tbody>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- title -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 18px; font-weight: 700; color: #146eb4      ; text-align:center; line-height: 24px;" st-title="3col-title3">
                                                            TODO LO QUE BUSCAS
                                                         </td>
                                                      </tr>
                                                      <!-- end of title -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      <!-- content -->
                                                      <tr>
                                                         <td style="font-family: \'Open Sans\', sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content3">
                                                            Dentro de nuestro catalogo podris encontrar todo tipo de inmuebles en venta y arriendo a lo largo y ancho de Venezuela.
                                                         </td>
                                                      </tr>
                                                      <!-- end of content -->
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                                                      </tr>
                                                      <!-- Spacing -->
                                                      
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <!-- end of text content table -->
                                       </tbody>
                                    </table>
                                 </td>
                                 <!-- spacing -->
                                 <!-- end of spacing -->
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of 3 Columns -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator --> 

 
<!-- Start Full Text -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">
                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td  align="center" class="devicewidth">
                                                   <img src="http://dptpropiedades.com/assets/img/logo_apaisado.png" alt="" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
                                             </td>

                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                        
                                          <!-- End of spacing -->
                                          <!-- content -->
                                         
                                          <!-- End of content -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                              <!-- Spacing -->
                             
                              <!-- Spacing -->
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- end of full text -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>
                  <tr>
                     <td COLSPAN="4" align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                  </tr>
                  <tr>
                     <td COLSPAN="4" width="550" align="left" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    
                  </tr>
                  <tr >
                  <td style="width: 35%;"></td><td style="width: 15%;"></td>
                     <td align="right" height="50" style="font-size:10px; line-height:1px; text-align: right;">
                           Diseñado y Desarrollado Por: 
                     </td>
                     <td align="center" height="50" style="font-size:12px; line-height:1px; text-align: left;">
                           
                              <a target="_blank" href="http://www.maymi.com.ve">
                                 <img src="http://www.dptpropiedades.com/assets/img/logo_maymi.png" alt="" height="20" border="0" style="display:block; border:none; outline:none; text-decoration:none;" class="colimg2">
                              </a>                 
                          
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of seperator -->  

   
   </body>
   </html>';

 

   return $cuerpo;
}

$name=$_POST['name'];
 $email=$_POST['email'];
 $phone=$_POST['telefono'];
 $message=$_POST['message'];

 /**$name='nombre';
 $email='Email';
 $phone='Telefono';
 $message='Mensaje';*/


$cuerpo=genera_correo($name, $phone, $message);

#echo $cuerpo;


$destinatario = $email;
$asunto = "Dpt Propiedades - Contacto";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
 
//dirección del remitente
$headers .= "To: ".$email." \r\n";
$headers .= "From: Dpt Propiedades <info@dptpropiedades.com> \r\n";

 
//dirección de respuesta, si queremos que sea distinta que la del remitente

 
//direcciones que recibián copia
//$headers .= "Cc: miguelmachadoaa@gmail.com\r\n";
 
//direcciones que recibirán copia oculta
$headers .= "Bcc: miguelmachadoaa@gmail.com \r\n";
$headers .= "Bcc: info@dptpropiedades.com \r\n";
//$headers .= "Cc: miguelmachadoaa@gmail.com\r\n";

$respuesta_mail=mail($destinatario,$asunto,$cuerpo,$headers);

if ($respuesta_mail) {
   echo "true";
}else{
   echo "false";
}