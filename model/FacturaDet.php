<?php
/**
 * Description of FacturaDet
 *
 * @author mrea
 */
class FacturaDet {
    private $idFacturaDet;
    private $idFacturaCab;
    private $idProducto;
    private $nombreProducto;//campo solo informativo, no consta en la tabla.
    private $precio;
    private $cantidad;
    private $porcentajeIva;
    private $subtotal;
    public function getIdFacturaDet() {
        return $this->idFacturaDet;
    }

    public function getIdFacturaCab() {
        return $this->idFacturaCab;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }
    
    public function getNombreProducto() {
        return $this->nombreProducto;
    }

    public function setNombreProducto($nombreProducto) {
        $this->nombreProducto = $nombreProducto;
    }

        public function getPrecio() {
        return $this->precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPorcentajeIva() {
        return $this->porcentajeIva;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function setIdFacturaDet($idFacturaDet) {
        $this->idFacturaDet = $idFacturaDet;
    }

    public function setIdFacturaCab($idFacturaCab) {
        $this->idFacturaCab = $idFacturaCab;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setPorcentajeIva($porcentajeIva) {
        $this->porcentajeIva = $porcentajeIva;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }


}
