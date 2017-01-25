<?php
include_once 'Database.php';
include_once 'Cliente.php';
include_once 'Producto.php';
include_once 'FacturaCab.php';
include_once 'FacturaDet.php';
include_once 'CrudModel.php';
/**
 * Clase que implementa la logica de facturacion.
 *
 * @author mrea
 */
class FacturaModel {
    public function getFacturas(){
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from factura_cab order by id_factura_cab desc";
        $resultado = $pdo->query($sql);
        //transformamos los registros en objetos:
        $listado = array();
        foreach ($resultado as $res) {
            $factura = new FacturaCab();
            $factura->setIdFacturaCab($res['id_factura_cab']);
            $factura->setFecha($res['fecha']);
            $factura->setCedula($res['cedula']);
            $factura->setEstado($res['estado']);
            $factura->setBaseImponible($res['base_imponible']);
            $factura->setBaseNoImponible($res['base_no_imponible']);
            $factura->setValorIva($res['valor_iva']);
            $factura->setTotal($res['total']);
            array_push($listado, $factura);
        }
        Database::disconnect();
        //retornamos el listado resultante:
        return $listado;
    }
    /**
     * Funcion que adiciona un nuevo producto en los detalles de una factura. La lista
     * de detalles se encuentra en memoria.
     * @param type $listaFacturaDet Lista de detalles de factura.
     * @param type $idProducto Codigo del producto.
     * @param type $cantidad La cantidad de compra.
     * @throws Exception
     * @return array
     */
    public function adicionarDetalle($listaFacturaDet,$idProducto,$cantidad){
        if($cantidad<=0){
            throw new Exception ("La cantidad debe ser mayor a cero.");
        }
        //buscamos el producto:
        $crudModel=new CrudModel();
        $producto=$crudModel->getProducto($idProducto);
        //creamos un nuevo detalle FacturaDet:
        $facturaDet=new FacturaDet();
        $facturaDet->setIdProducto($producto->getIdProducto());
        $facturaDet->setNombreProducto($producto->getNombre());
        $facturaDet->setCantidad($cantidad);
        $facturaDet->setPrecio($producto->getPrecio());
        $facturaDet->setPorcentajeIva($producto->getPorcentajeIva());
        $facturaDet->setSubtotal($cantidad * $producto->getPrecio());
        //adicionamos el nuevo detalle al array en memoria:
        if(!isset($listaFacturaDet)){
            $listaFacturaDet=array();
        }
        array_push($listaFacturaDet,$facturaDet);
        return $listaFacturaDet;
    }
    
    public function eliminarDetalle($listaFacturaDet,$idProducto){
        //buscamos el producto:
        $cont=0;
        foreach ($listaFacturaDet as $det) {
            if($det->getIdProducto()==$idProducto){
                unset($listaFacturaDet[$cont]);
                //reindexamos el array para eliminar el lugar vacio:
                $listaFacturaDet=  array_values($listaFacturaDet);
                break;
            }
            $cont++;
        }
        return $listaFacturaDet;
    }
    
    public function calcularBaseImponible($listaFacturaDet){
        if(!isset($listaFacturaDet)){
            return 0;
        }
        $baseImponible=0;
        foreach ($listaFacturaDet as $facturaDet) {
            if($facturaDet->getPorcentajeIva()>0){
                $baseImponible+=$facturaDet->getSubtotal();
            }
        }
        return $baseImponible;
    }
    
    public function calcularBaseNoImponible($listaFacturaDet){
        if(!isset($listaFacturaDet)){
            return 0;
        }
        $baseNoImponible=0;
        foreach ($listaFacturaDet as $facturaDet) {
            if($facturaDet->getPorcentajeIva()==0){
                $baseNoImponible+=$facturaDet->getSubtotal();
            }
        }
        return $baseNoImponible;
    }
    
    public function calcularIva($listaFacturaDet){
        if(!isset($listaFacturaDet)){
            return 0;
        }
        $iva=0;
        foreach ($listaFacturaDet as $facturaDet) {
            if($facturaDet->getPorcentajeIva()>0){
                $iva+=$facturaDet->getSubtotal()*$facturaDet->getPorcentajeIva()/100;
            }
        }
        return round($iva,2);
    }
    
    public function calcularTotal($listaFacturaDet){
        if(!isset($listaFacturaDet)){
            return 0;
        }
        $total= $this->calcularBaseImponible($listaFacturaDet) +
                $this->calcularBaseNoImponible($listaFacturaDet) +
                $this->calcularIva($listaFacturaDet);
        return $total;
    }
    
    public function ultimoNumeroFactura(){
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select max(id_factura_cab) numero from factura_cab";
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        //obtenemos el registro especifico:
        $res=$consulta->fetch(PDO::FETCH_ASSOC);
        $numero=$res['numero'];
        Database::disconnect();
        //retornamos el numero encontrado:
        if(!isset($numero))
            return 0;
        return $numero;
    }
    
    public function guardarFactura($listaFacturaDet,$cedula){
        if(!isset($listaFacturaDet)){
            throw new Exception("Debe por lo menos registrar un producto.");
        }
        if(count($listaFacturaDet)==0){
            throw new Exception("Debe por lo menos registrar un producto.");
        }
        if(!isset($cedula)){
            throw new Exception("Debe seleccionar el cliente.");
        }
        //obtenemos los datos completos del cliente:
        $crudModel=new CrudModel();
        $cliente=$crudModel->getCliente($cedula);
        //creamos la nueva factura:
        $facturaCab = new FacturaCab();
        $facturaCab->setCedula($cedula);
        $facturaCab->setNombresCliente($cliente->getApellidos()." ".$cliente->getNombres());
        $facturaCab->setDireccionCliente($cliente->getDireccion());
        $facturaCab->setEstado("S");
        $facturaCab->setFecha(date('Y-m-d'));
        $facturaCab->setBaseImponible($this->calcularBaseImponible($listaFacturaDet));
        $facturaCab->setBaseNoImponible($this->calcularBaseNoImponible($listaFacturaDet));
        $facturaCab->setValorIva($this->calcularIva($listaFacturaDet));
        $facturaCab->setTotal($this->calcularTotal($listaFacturaDet));
        //obtenemos el siguiente numero de factura:
        $facturaCab->setIdFacturaCab($this->ultimoNumeroFactura()+1);
        //guardar la cabecera:
        $pdo = Database::connect();
        $sql = "insert into factura_cab(id_factura_cab,fecha,cedula,estado,base_imponible,base_no_imponible,valor_iva,total) values(?,?,?,?,?,?,?,?)";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros:
        try {
            $consulta->execute(array($facturaCab->getIdFacturaCab(),
                                     $facturaCab->getFecha(),
                                     $facturaCab->getCedula(),
                                     $facturaCab->getEstado(),
                                     $facturaCab->getBaseImponible(),
                                     $facturaCab->getBaseNoImponible(),
                                     $facturaCab->getValorIva(),
                                     $facturaCab->getTotal()));
            //guardamos los detalles:
            foreach ($listaFacturaDet as $det){
                $sql = "insert into factura_det(id_factura_cab,id_producto,precio,cantidad,porcentaje_iva,subtotal) values(?,?,?,?,?,?)";
                $consulta = $pdo->prepare($sql);
                //en cada detalle asignamos el numero de factura padre:
                $consulta->execute(array($facturaCab->getIdFacturaCab(),
                                     $det->getIdProducto(),
                                     $det->getPrecio(),
                                     $det->getCantidad(),
                                     $det->getPorcentajeIva(),
                                     $det->getSubtotal()));
            }
        } catch (PDOException $e) {
            Database::disconnect();
            throw new Exception($e->getMessage());
        }
        Database::disconnect();
        return $facturaCab;
    }
    
}
