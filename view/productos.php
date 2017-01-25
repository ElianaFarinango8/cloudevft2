<!DOCTYPE html>
<?php
require_once '../model/Producto.php';
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturación - productos</title>
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
                <h3>Productos</h3>
            </div>
            <div class="row">
                <a class="btn btn-success" href="../view/index.php">Inicio</a>
            </div>
            <p>
                <form action="../controller/controller.php">
                    <input type="hidden" name="opcion" value="crear_producto">
                    Nombre del producto:<input type="text" name="nombre" maxlength="100" required="true">
                    Precio:<input type="text" name="precio" maxlength="10" required="true">
                    IVA (0/12):<input type="text" name="porcentajeIva" maxlength="5" required="true">
                    <input type="submit" value="Crear">
                </form>
            </p>
            <table data-toggle="table">
                <thead>
                    <tr>
                        <th>ID PRODUCTO</th>
                        <th>NOMBRE</th>
                        <th>PRECIO</th>
                        <th>IVA</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //verificamos si existe en sesion el listado de productos:
                    if (isset($_SESSION['listaProductos'])) {
                        $listado = unserialize($_SESSION['listaProductos']);
                        foreach ($listado as $producto) {
                            echo "<tr>";
                            echo "<td>" . $producto->getIdProducto() . "</td>";
                            echo "<td>" . $producto->getNombre() . "</td>";
                            echo "<td>" . $producto->getPrecio() . "</td>";
                            echo "<td>" . $producto->getPorcentajeIva() . "</td>";
                            echo "<td><a href='../controller/controller.php?opcion=editar_producto&idProducto=" . $producto->getIdProducto() . "'><span class='glyphicon glyphicon-pencil'> Editar </span></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "No se han cargado datos.";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
