<?php
/**
 * Description of Producto
 *
 * @author mrea
 */
class Producto {
    private $idProducto;
    private $nombre;
    private $precio;
    private $porcentajeIva;
    
    function __construct($idProducto, $nombre, $precio, $porcentajeIva) {
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->porcentajeIva = $porcentajeIva;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getPorcentajeIva() {
        return $this->porcentajeIva;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setPorcentajeIva($porcentajeIva) {
        $this->porcentajeIva = $porcentajeIva;
    }


}
