<!DOCTYPE html>
<?php
require_once '../model/Cliente.php';
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturación - clientes</title>
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
                <h3>Clientes</h3>
            </div>
            <div class="row">
                <a class="btn btn-success" href="../view/index.php">Inicio</a>
            </div>
            <p>
                <form action="../controller/controller.php">
                    <input type="hidden" name="opcion" value="crear_cliente">
                    Cédula:<input type="text" name="cedula" maxlength="10" required="true">
                    Apellidos:<input type="text" name="apellidos" maxlength="50" required="true">
                    Nombres:<input type="text" name="nombres" maxlength="50" required="true">
                    Direccion:<input type="text" name="direccion" maxlength="100">
                    <input type="submit" value="Crear">
                </form>
            </p>
            <table data-toggle="table">
                <thead>
                    <tr>
                        <th>CEDULA</th>
                        <th>APELLIDOS</th>
                        <th>NOMBRES</th>
                        <th>DIRECCION</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //verificamos si existe en sesion el listado de clientes:
                    if (isset($_SESSION['listaClientes'])) {
                        $listado = unserialize($_SESSION['listaClientes']);
                        foreach ($listado as $cliente) {
                            echo "<tr>";
                            echo "<td>" . $cliente->getCedula() . "</td>";
                            echo "<td>" . $cliente->getApellidos() . "</td>";
                            echo "<td>" . $cliente->getNombres() . "</td>";
                            echo "<td>" . $cliente->getDireccion() . "</td>";
                            echo "<td><a href='../controller/controller.php?opcion=editar_cliente&cedula=" . $cliente->getCedula() . "'><span class='glyphicon glyphicon-pencil'> Editar </span></a></td>";
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
