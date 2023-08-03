<?php
    session_start();
        include_once("conexionBD.php");
        include_once("utiles.php");
        include_once("funcionesSistemaGeneral.php");
        include_once('tcpdf/tcpdf.inc.php');
        require_once('tcpdf/tcpdf_include.php');
        include_once('numeroToLetra.php');
        
        $cod_unidad=$_SESSION['cod_unidad'];

        $fechaI=date("Y-m-d");
        $folio=-1;

        $sumaSubtotal=0;
        $sumaIVA=0;
        $sumaTotal=0;

        $nombreEmpresa="Nombre de la empresa";

        if(isset($_POST['folio']))
        {
            $folio=$_POST['folio'];
        }else{
            $folio=$_GET['folio'];
        }

        //$folio=5;

        $consultarDatosEmpresa="SELECT * FROM 4000_config_empresa WHERE cod_unidad='".$cod_unidad."'";
        $res=$con->obtenerPrimeraFila($consultarDatosEmpresa);
        
        if($res)
        {
            $nombreEmpresa=$res[5];
            $rfc=$res[8];
            $logo='../vista/'.$res[18];
        }

        $consultaCabeceraCompra="SELECT * FROM 4009_compras_cabecera WHERE idCompra='".$folio."'";
        $resCabe=$con->obtenerPrimeraFila($consultaCabeceraCompra);

        $idProveedor=$resCabe[4];
        $totalSubtotal=formatearMoneda($resCabe[5]);
        $totalIVA=formatearMoneda($resCabe[6]);
        $granTotal=formatearMoneda($resCabe[7]);
        $fechaCompra=cambiarFormatoFecha($resCabe[2]);
        $idTipoCompra=$resCabe[8];

        $nomTipoCompra=obtenerNombreTipoCompra($idTipoCompra);
        
        $nombreProveedor=obtenerNombreClienteProveedor($idProveedor,'2');

        

        $consultaDetalle="SELECT * FROM 4010_compras_detalle WHERE idCompras='".$folio."' ORDER BY idCompraDetalle";
        $resDetalle=$con->obtenerFilas($consultaDetalle);

        class myPdf extends TCPDF
        {
            
        }

        $pdf = new myPdf('P','mm','Letter', true, 'UTF-8', false); //array(ancho,largo)
 
        $pdf->SetMargins('PDF_MARGIN_LEFT', '10', PDF_MARGIN_RIGHT);  // se define margen del texto centra
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);  //distancia de donde empieza la hoja a la cabecera
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  

        $pdf->SetFont('times', '', 10);
        $pdf->AddPage();

        $text ='
                <!DOCTYPE html>
                    <html lang="es">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Document</title>
                            <style>
                                .tituloEmpresa {
                                    font-size: 10pt;
                                    text-align: center;
                                    font-weight: bold;
                                }

                                .rfcEmpresa {
                                    text-align: center;
                                    font-size: 8pt;
                                }

                                .rfcEmpresa span {
                                    font-weight: bold;
                                }

                                .datos {
                                    font-size: 8pt;
                                    text-align: left;
                                    padding-left: 10px;
                                }

                                .datos span {
                                    font-weight: bold;
                                    margin-left: 5pt;
                                }

                                .tituloOrden {
                                    font-size: 8pt;
                                    text-align: center;
                                    font-weight: bold;
                                }

                                .cabecera {
                                    font-size: 7pt;
                                    text-align: center;
                                    background-color: #93B5C6;
                                }

                                .datosResulUno {
                                    font-size: 6pt;
                                    text-align: center;
                                }

                                .datosResulDos {
                                    font-size: 6pt;
                                    text-align: right;
                                    padding-right: 10pt;
                                }

                                .txtTotales {
                                    font-size: 8pt;
                                    text-align: right;
                                    padding-right: 10pt;
                                    font-weight: bold;
                                }
                            </style>
                        </head>

                        <body>

                            <table width="90%" border="0" align="center">
                                <tr>
                                    <td p-0>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="tituloEmpresa p-0">'.$nombreEmpresa.'</td>
                                </tr>
                                <tr>
                                    <td class="rfcEmpresa p-0">R.F.C. <span>'.$rfc.'</span> </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                            <table width="90%" border="0" align="center">
                                <tr>
                                    <td width="70%" class="datos">Folio: <span>'.$folio.'</span></td>
                                    <td width="30%" class="tituloOrden">ORDEN DE COMPRA</td>
                                </tr>
                                <tr>
                                    <td width="70%" class="datos">Proveedor: <span>'.$nombreProveedor.'</span></td>
                                    <td width="30%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="70%" class="datos">Fecha de compra: <span>'.$fechaCompra.'</span></td>
                                    <td width="30%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="70%" class="datos">Tipo de compra: <span>'.$nomTipoCompra.'</span></td>
                                    <td width="30%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="70%">&nbsp;</td>
                                    <td width="30%">&nbsp;</td>
                                </tr>
                            </table>

                            <table width="90%" border="0" align="center">
                                <tr>
                                    <th width="10%" class="cabecera">CODIGO</th>
                                    <th width="60%" class="cabecera">PRODUCTO</th>
                                    <th width="10%" class="cabecera">CANTIDAD</th>
                                    <th width="10%" class="cabecera">COSTO</th>
                                    <th width="10%" class="cabecera">TOTAL</th>
                                </tr>
        ';
                    while($fila=mysql_fetch_row($resDetalle))
                    {
                        $idProducto=$fila[7];
                        $codProducto=$fila[2];
                        $cantidad=$fila[3];
                        $costoU=formatearMoneda($fila[4]);
                        $iva=$fila[5];
                        $total=formatearMoneda($fila[6]);
                        $nombreProducto=obtenerNombreProducto($idProducto);

                        $requiereBascula=requiereBasculaProducto($idProducto);

                        if($requiereBascula==1)
                        {
                            $cantidadProd=$cantidad." kg(s)";
                        }else{
                            $cantidadProd=$cantidad." Und(s)";
                        }
                        

                        $text.='
                                    <tr>
                                        <td width="10%" class="datosResulUno">'.$codProducto.'</td>
                                        <td width="60%" class="datosResulUno">'.$nombreProducto.'</td>
                                        <td width="10%" class="datosResulUno">'.$cantidadProd.'</td>
                                        <td width="10%" class="datosResulDos">'.$costoU.'</td>
                                        <td width="10%" class="datosResulDos">'.$total.'</td>
                                    </tr>
                        ';
                    }

    $text.='
                                <tr>
                                    <td width="10%" class="">&nbsp;</td>
                                    <td width="60%" class="">&nbsp;</td>
                                    <td width="10%" class="">&nbsp;</td>
                                    <td width="10%" class="">&nbsp;</td>
                                    <td width="10%" class="">&nbsp;</td>
                                </tr>
                            </table>

                            <table width="90%" border="0" align="center">
                                <tr>
                                    <td width="80%" class="">&nbsp;</td>
                                    <td width="10%" class="txtTotales">Subtotal</td>
                                    <td width="10%" class="datosResulDos">'.$totalSubtotal.'</td>
                                </tr>
                                <tr>
                                    <td width="80%" class="">&nbsp;</td>
                                    <td width="10%" class="txtTotales">IVA</td>
                                    <td width="10%" class="datosResulDos">'.$totalIVA.'</td>
                                </tr>
                                <tr>
                                    <td width="80%" class="">&nbsp;</td>
                                    <td width="10%" class="txtTotales">Total</td>
                                    <td width="10%" class="datosResulDos">'.$granTotal.'</td>
                                </tr>
                            </table>
                        </body>
                    </html>

           
           
                
        ';

 



    $js="";
    $pdf->writeHTML($text,false,true,false,0);
    $js .= 'print(true);';

    // set javascript
    $pdf->IncludeJS($js);

    //Close and output PDF document
    $pdf->Output('Compra_'.$folio.'.pdf','I');


    function formatearMoneda($monto)
    {
        return '$ '.number_format($monto,2);
    }




        

?>