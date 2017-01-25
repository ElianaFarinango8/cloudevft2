<?php
include_once 'Database.php';
include_once 'Cliente.php';
include_once 'Producto.php';
/**
 * Clase para el manejo CRUD de clientes y productos.
 *
 * @author mrea
 */
class CrudModel {
    //////////////////////////
    //CLIENTES:
    //////////////////////////
    
    /**
     * Retorna la lista de clientes de la bdd.
     * @return array
     */
    public function getClientes() {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from cliente order by apellidos";
        $resultado = $pdo->query($sql);
        //transformamos los registros en objetos:
        $listado = array();
        foreach ($resultado as $res) {
            $cliente = new Cliente($res['cedula'], $res['apellidos'], $res['nombres'], $res['direccion']);
            array_push($listado, $cliente);
        }
        Database::disconnect();
        //retornamos el listado resultante:
        return $listado;
    }
    
    /**
     * Busca la informacion de un cliente especifico.
     * @param type $cedula El numero de cedula del cliente.
     * @return type
     */
    public function getCliente($cedula) {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from cliente where cedula=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($cedula));
        //obtenemos el registro especifico:
        $res=$consulta->fetch(PDO::FETCH_ASSOC);
        $cliente=new Cliente($res['cedula'], $res['apellidos'], $res['nombres'], $res['direccion']);
        Database::disconnect();
        //retornamos el objeto encontrado:
        return $cliente;
    }

    /**
     * Inserta un nuevo cliente en la bdd.
     * @param type $cedula
     * @param type $apellidos
     * @param type $nombres
     * @param type $direccion
     * @throws Exception
     */
    public function insertarCliente($cedula,$apellidos,$nombres,$direccion) {
        $pdo = Database::connect();
        $sql = "insert into cliente(cedula,apellidos,nombres,direccion) values(?,?,?,?)";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros:
        try {
            $consulta->execute(array($cedula,$apellidos,$nombres,$direccion));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }
    
    /**
     * Elimina un cliente especifico de la bdd.
     * @param type $cedula
     */
    public function eliminarCliente($cedula){
        //Preparamos la conexion a la bdd:
        $pdo=Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="delete from cliente where cedula=?";
        $consulta=$pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($cedula));
        Database::disconnect();
    }
    /**
     * Actualiza un cliente existente.
     * @param type $cedula
     * @param type $apellidos
     * @param type $nombres
     * @param type $direccion
     */
    public function actualizarCliente($cedula,$apellidos,$nombres,$direccion){
        //Preparamos la conexión a la bdd:
        $pdo=Database::connect();
        $sql="update cliente set apellidos=?,nombres=?,direccion=? where cedula=?";
        $consulta=$pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($cedula,$apellidos,$nombres,$direccion));
        Database::disconnect();
    }
    
    //////////////////////////
    //PRODUCTOS:
    //////////////////////////
    
    /**
     * Retorna la lista de productos de la bdd.
     * @return array
     */
    public function getProductos() {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from producto order by nombre";
        $resultado = $pdo->query($sql);
        //transformamos los registros en objetos:
        $listado = array();
        foreach ($resultado as $res) {
            $producto = new Producto($res['id_producto'], $res['nombre'], $res['precio'], $res['porcentaje_iva']);
            array_push($listado, $producto);
        }
        Database::disconnect();
        //retornamos el listado resultante:
        return $listado;
    }
    
    /**
     * Busca la informacion de un producto especifico.
     * @param type $idProducto El codigo del producto.
     * @return type
     */
    public function getProducto($idProducto) {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from producto where id_producto=?";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array($idProducto));
        //obtenemos el objeto especifico:
        $res=$consulta->fetch(PDO::FETCH_ASSOC);
        $producto=new Producto($res['id_producto'], $res['nombre'], $res['precio'], $res['porcentaje_iva']);
        Database::disconnect();
        //retornamos el objeto encontrado:
        return $producto;
    }

    /**
     * Inserta un nuevo producto en la bdd.
     * @param type $nombre
     * @param type $precio
     * @param type $porcentajeIva
     * @throws Exception
     */
    public function insertarProducto( $nombre, $precio, $porcentajeIva) {
        $pdo = Database::connect();
        $sql = "insert into producto(nombre,precio,porcentaje_iva) values(?,?,?)";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros:
        try {
            $consulta->execute(array($nombre,$precio,$porcentajeIva));
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
    }
    
    /**
     * Elimina un producto especifico de la bdd.
     * @param type $idProducto
     */
    public function eliminarProducto($idProducto){
        //Preparamos la conexion a la bdd:
        $pdo=Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="delete from producto where id_producto=?";
        $consulta=$pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($idProducto));
        Database::disconnect();
    }
    /**
     * Actualiza un producto existente.
     * @param type $idProducto
     * @param type $nombre
     * @param type $precio
     * @param type $porcentajeIva
     */
    public function actualizarProducto($idProducto, $nombre, $precio, $porcentajeIva){
        //Preparamos la conexión a la bdd:
        $pdo=Database::connect();
        $sql="update producto set nombre=?,precio=?,porcentaje_iva=? where id_producto=?";
        $consulta=$pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($idProducto,$nombre,$precio,$porcentajeIva));
        Database::disconnect();
    }
}
