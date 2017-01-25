<!DOCTYPE html>
<?php
require_once '../model/Cliente.php';
require_once '../model/Producto.php';
require_once '../model/FacturaDet.php';
require_once '../model/CrudModel.php';
require_once '../model/FacturaModel.php';
session_start();
$crudModel = new CrudModel();
$facturaModel = new FacturaModel();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturación - factura</title>
        <script src="js/jquery-2.1.4.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-table.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <img src="images/banner-facturacion.jpg">
            <div class="row">
                <h3>Nueva factura</h3>
            </div>
            <div class="row">
                <a class="btn btn-success" href="../view/index.php">Inicio</a>
                <?php
                if (isset($_SESSION['mensajeError'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['mensajeError'] . "</div>";
                }
                ?>
            </div>
            <p>
            <form action="../controller/controller.php">
                <input type="hidden" name="opcion" value="guardar_factura">
                Seleccione el cliente:
                <select name="cedula">
                    <?php
                    
                    $listaClientes = $crudModel->getClientes();
                    foreach ($listaClientes as $cliente) {
                        echo "<option value='" . $cliente->getCedula() . "'>" . $cliente->getApellidos() . " " . $cliente->getNombres() . "</option>";
                    }
                    ?>
                </select>
                Fecha:<input type="date" name="fecha" required="true" autocomplete="off" required="" value="<?php echo date('Y-m-d'); ?>">
                <input type="submit" value="Guardar factura">
            </form>
        </p>
        <p>
        <form action="../controller/controller.php">
            <input type="hidden" name="opcion" value="adicionar_detalle">
            Seleccione el producto:
            <select name="idProducto">
                <?php
                $listaProductos = $crudModel->getProductos();
                foreach ($listaProductos as $prod) {
                    echo "<option value='" . $prod->getIdProducto() . "'>" . $prod->getNombre() . "</option>";
                }
                ?>
            </select>
            Cantidad:<input type="text" name="cantidad" maxlength="10" required="true" value="1">
            <input type="submit" value="Adicionar">
        </form>
    </p>
    <table data-toggle="table">
        <thead>
            <tr>
                <th>ID PRODUCTO</th>
                <th>NOMBRE</th>
                <th>PRECIO</th>
                <th>CANTIDAD</th>
                <th>IVA</th>
                <th>SUBTOTAL</th>
                <th>OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //verificamos si existe en sesion el listado de clientes:
            if (isset($_SESSION['listaFacturaDet'])) {
                $listado = unserialize($_SESSION['listaFacturaDet']);
                foreach ($listado as $facturaDet) {
                    echo "<tr>";
                    echo "<td>" . $facturaDet->getIdProducto() . "</td>";
                    echo "<td>" . $facturaDet->getNombreProducto() . "</td>";
                    echo "<td>" . $facturaDet->getPrecio() . "</td>";
                    echo "<td>" . $facturaDet->getCantidad() . "</td>";
                    echo "<td>" . $facturaDet->getPorcentajeIva() . "</td>";
                    echo "<td>" . $facturaDet->getSubtotal() . "</td>";
                    echo "<td><a href='../controller/controller.php?opcion=eliminar_detalle&idProducto=" . $facturaDet->getIdProducto() . "'>Eliminar</a></td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>BASE IMPONIBLE</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaModel->calcularBaseImponible($listado) . "</td>";
                echo "<td></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>BASE NO IMPONIBLE</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaModel->calcularBaseNoImponible($listado) . "</td>";
                echo "<td></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>IVA</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaModel->calcularIva($listado) . "</td>";
                echo "<td></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>TOTAL</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaModel->calcularTotal($listado) . "</td>";
                echo "<td></td>";
                echo "</tr>";
            } else {
                echo "No se han cargado datos.";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
