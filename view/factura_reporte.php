<!DOCTYPE html>
<?php
require_once '../model/Cliente.php';
require_once '../model/Producto.php';
require_once '../model/FacturaDet.php';
require_once '../model/CrudModel.php';
require_once '../model/FacturaModel.php';
session_start();
$facturaCab=$_SESSION['facturaCab'];
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
                <h3>Factura</h3>
            </div>
            <div class="row">
                <a class="btn btn-success" href="../view/index.php">Inicio</a>
                <a class="btn btn-success" href="javascript:window.print()">Imprimir</a>
            </div>
            <p>
            <table>
                <tr>
                    <td>Nro. factura:</td>
                    <td><?php echo $facturaCab->getIdFacturaCab(); ?></td>
                </tr>
                <tr>
                    <td>Fecha:</td>
                    <td><?php echo $facturaCab->getFecha(); ?></td>
                </tr>
                <tr>
                    <td>Estado de la factura:</td>
                    <td><?php echo $facturaCab->getEstado(); ?></td>
                </tr>
                <tr>
                    <td>Cédula:</td>
                    <td><?php echo $facturaCab->getCedula(); ?></td>
                </tr>
                <tr>
                    <td>Cliente:</td>
                    <td><?php echo $facturaCab->getNombresCliente(); ?></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td><?php echo $facturaCab->getDireccionCliente(); ?></td>
                </tr>
            </table>
            
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
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>BASE IMPONIBLE</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaCab->getBaseImponible() . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>BASE NO IMPONIBLE</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaCab->getBaseNoImponible() . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>IVA</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaCab->getValorIva() . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> </td>";
                echo "<td>TOTAL</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>" . $facturaCab->getTotal() . "</td>";
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
