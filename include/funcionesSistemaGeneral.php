<?php

function obtenerNombreEmpresaGeneral($id)
{
    global $con;
    $consulta="SELECT IF(tipoEmpresa=2,Nombre ,CONCAT(Nombre,' ',apPaterno,' ',apMaterno))AS nombre 
            FROM 1002_empresa WHERE idEmpresa='".$id."'";
    $nombre=$con->obtenerValor($consulta);
    
    return $nombre;
}

function obtenerNombrePerfilUsuario($id)
{
    global $con;
    $perfil="";

    $consulta="SELECT nombrePerfil FROM 1004_perfiles WHERE idPerfil='".$id."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $perfil=strtoupper($res);
    }

    return $perfil;
}

/*BUSCAMOS CODIGO UNIDAD CONOCIENDO EL ID EMPRESA */

function obtenerCodigoUnidadEmpresa($id)
{
    global $con;

    $consulta="SELECT cod_unidad FROM 1002_empresa WHERE idEmpresa='".$id."'";
    $resp=$con->obtenerValor($consulta);

    return $resp;
}

/* FUNCIONES PERSONAL EMPRESA */
function obtenerNombrePersonal($id)
{
    global $con;
    $nomPersonal="";

    $consulta="SELECT nombre FROM 4014_cat_personal WHERE idPersonal='".$id."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $nomPersonal=strtoupper($res);
    }

    return $nomPersonal;
    
}

/*==========================================
    #FUNCIONES DE CAJA
============================================*/

function obtenerNombreCategoria($idCategoria)
{
    global $con;

    $valor="";

    $consulta="SELECT nombre_categoria FROM 4001_categorias WHERE id_categoria='".$idCategoria."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $valor=strtoupper($res);
    }

    return $valor;
}

function obtenerFolioBoletaNuevo($folioA)
{
    $folioViejo=$folioA;
    $folioNuevo=$folioA+1;

    //echo "folio anterios ".$folioViejo." Folio nuevo ".$folioNuevo;

    switch(strlen($folioNuevo))
            {
                case 1:
                        $folio='0000000'.$folioNuevo;
                break;
                case '2':
                        $folio='000000'.$folioNuevo;
                break;
                case '3':
                        $folio='00000'.$folioNuevo;
                break;
                case '4':
                    $folio='0000'.$folioNuevo;
                break;
                case '5':
                    $folio='000'.$folioNuevo;
                break;  
                case '6':
                    $folio='00'.$folioNuevo;
                break;  
                case '7':
                    $folio='0'.$folioNuevo;
                break;
                case '8':
                    $folio=$folioNuevo;
                break;            
            }

    
    return $folio;

}

function obtenerExistenciaProducto($idProducto)
{
    global $con;

    $valor=0;

    $consulta="SELECT SUM(valorMovimiento*cantidad) AS resultado FROM 4006_inventario WHERE idProducto='".$idProducto."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $valor=$res;
    }

    return $valor;
}

function obtenerNombreProducto($id)
{
    global $con;
    $valor="";

    $consulta="SELECT codigo_producto,descripcion_producto FROM 3001_cat_productos WHERE idProducto='".$id."'";
    $res=$con->obtenerPrimeraFila($consulta);

    if($res)
    {
        $valor="[".$res[0]."] ".$res[1];
       
    }

    return $valor;

}

function obtenerNombreTipoCompra($id)
{
    global $con;

    $valor="";

    $consulta="SELECT concepto FROM 4011_estatusCompraVenta WHERE idSituacion='".$id."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $valor=strtoupper($res);
    }

    return $valor;

}

function requiereBasculaProducto($id)
{
    global $con;
    $valor=0;

    $consulta="SELECT aplica_peso FROM 4001_categorias c, 3001_cat_productos p 
            WHERE p.idCategoria=c.id_categoria AND p.idProducto='".$id."'";
     $res=$con->obtenerValor($consulta);  
     
     if($res)
    {
        $valor=$res;
    }

    return $valor;

}

/*==========================================
    #FUNCIONES DE PAGOS Y ABONOS
============================================*/
function obtenerTotalAbonosPedido($id)
{
    global $con;
    $valor=0;

    $consulta="SELECT SUM(importe) FROM 4017_abonosPedidosPersonal WHERE idPedido='".$id."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $valor=$res;
    }

    return $valor;
}

//FUNCIONES GASTOS
function obtenerNombreGasto($id)
{
    global $con;
    $valor="";

    $consulta="SELECT nombreTipo FROM 4021_cat_tipoGasto WHERE idTipoGasto='".$id."'";
    $res=$con->obtenerValor($consulta);

    if($res)
    {
        $valor=strtoupper($res);
    }

    return $valor;
}



?>