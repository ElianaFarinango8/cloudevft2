<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistema de facturación</title>
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
                <h3>Sistema de Facturación</h3>
            </div>
            <div class="row">
                <a class="btn btn-success" href="../controller/controller.php?opcion=listar_clientes">Clientes</a>
                <a class="btn btn-success" href="../controller/controller.php?opcion=listar_productos">Productos</a>
                <a class="btn btn-success" href="../controller/controller.php?opcion=listar_facturas">Lista de facturas</a>
                <a class="btn btn-success" href="../controller/controller.php?opcion=nueva_factura">Nueva factura</a>
            </div>
        </div>
    </body>
</html>
