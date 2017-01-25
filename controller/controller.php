<?php
///////////////////////////////////////////////////////////////////////
//Componente controller que verifica la opcion seleccionada
//por el usuario, ejecuta el modelo y enruta la navegacion de paginas.
///////////////////////////////////////////////////////////////////////
require_once '../model/CrudModel.php';
require_once '../model/FacturaModel.php';
session_start();
//instanciamos los objetos de negocio:
$crudModel = new CrudModel();
$facturaModel = new FacturaModel();
//recibimos la opcion desde la vista:
$opcion = $_REQUEST['opcion'];
$mensajeError="";
//limpiamos cualquier mensaje previo:
unset($_SESSION['mensajeError']);
switch($opcion){
    case "listar_clientes":
        //obtenemos la lista:
        $listaClientes = $crudModel->getClientes();
        //y los guardamos en sesion:
        $_SESSION['listaClientes'] = serialize($listaClientes);
        //redireccionamos a una nueva pagina para visualizar:
        header('Location: ../view/clientes.php');
        break;
    case "listar_productos":
        //obtenemos la lista:
        $listaProductos = $crudModel->getProductos();
        //y los guardamos en sesion:
        $_SESSION['listaProductos'] = serialize($listaProductos);
        //redireccionamos a una nueva pagina para visualizar:
        header('Location: ../view/productos.php');
        break;
    case "crear_cliente":
        //obtenemos los parametros del formulario:
        $cedula=$_REQUEST['cedula'];
        $apellidos=$_REQUEST['apellidos'];
        $nombres=$_REQUEST['nombres'];
        $direccion=$_REQUEST['direccion'];
        //creamos el nuevo registro:
        $crudModel->insertarCliente($cedula, $apellidos, $nombres, $direccion);
        //actualizamos el listado:
        $listaClientes = $crudModel->getClientes();
        //y los guardamos en sesion:
        $_SESSION['listaClientes'] = serialize($listaClientes);
        //redireccionamos a una nueva pagina para visualizar:
        header('Location: ../view/clientes.php');
        break;
    case "crear_producto":
        //obtenemos los parametros del formulario:
        $nombre=$_REQUEST['nombre'];
        $precio=$_REQUEST['precio'];
        $porcentajeIva=$_REQUEST['porcentajeIva'];
        //creamos el nuevo registro:
        $crudModel->insertarProducto($nombre, $precio, $porcentajeIva);
        //actualizamos el listado:
        $listaProductos = $crudModel->getProductos();
        //y los guardamos en sesion:
        $_SESSION['listaProductos'] = serialize($listaProductos);
        //redireccionamos a una nueva pagina para visualizar:
        header('Location: ../view/productos.php');
        break;
    case "listar_facturas":
        //obtenemos la lista de facturas y subimos a sesion:
        $_SESSION['listaFacturas']=serialize($facturaModel->getFacturas());
        header('Location: ../view/facturas.php');
        break;
    case "nueva_factura":
        unset($_SESSION['listaFacturaDet']);
        header('Location: ../view/factura.php');
        break;
    case "adicionar_detalle":
        //obtenemos los parametros del formulario:
        $idProducto=$_REQUEST['idProducto'];
        $cantidad=$_REQUEST['cantidad'];
        if(!isset($_SESSION['listaFacturaDet'])){
            $listaFacturaDet=array();
        }else{
            $listaFacturaDet=unserialize($_SESSION['listaFacturaDet']);
        }
        try{
            $listaFacturaDet=$facturaModel->adicionarDetalle($listaFacturaDet, $idProducto, $cantidad);
            $_SESSION['listaFacturaDet']=serialize($listaFacturaDet);
        }catch(Exception $e){
            $mensajeError=$e->getMessage();
            $_SESSION['mensajeError']=$mensajeError;
        }
        header('Location: ../view/factura.php');
        break;
    case "eliminar_detalle":
        //obtenemos los parametros del formulario:
        $idProducto=$_REQUEST['idProducto'];
        $listaFacturaDet=unserialize($_SESSION['listaFacturaDet']);
        $listaFacturaDet=$facturaModel->eliminarDetalle($listaFacturaDet, $idProducto);
        $_SESSION['listaFacturaDet']=serialize($listaFacturaDet);
        header('Location: ../view/factura.php');
        break;
    case "guardar_factura":
        //obtenemos los parametros del formulario:
        $cedula=$_REQUEST['cedula'];
        if(isset($_SESSION['listaFacturaDet'])){
            $listaFacturaDet=unserialize($_SESSION['listaFacturaDet']);
            try {
                $facturaCab=$facturaModel->guardarFactura($listaFacturaDet, $cedula);
                $_SESSION['facturaCab']=$facturaCab;
                header('Location: ../view/factura_reporte.php');
                break;
            } catch (Exception $e) {
                $mensajeError=$e->getMessage();
                $_SESSION['mensajeError']=$mensajeError;
            }
        }
        //actualizamos lista de facturas:
        //$listado = $gastosModel->getFacturas();
        //$_SESSION['listado'] = serialize($listado);
        header('Location: ../view/factura.php');
        break;
    default:
        //si no existe la opcion recibida por el controlador, siempre
        //redirigimos la navegacion a la pagina index:
        header('Location: ../view/index.php');
}

