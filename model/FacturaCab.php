<?php
/**
 * Description of FacturaCab
 *
 * @author mrea
 */
class FacturaCab {
    private $idFacturaCab;
    private $fecha;
    private $cedula;
    private $nombresCliente;//campo solo informativo, no consta en la tabla.
    private $direccionCliente;//campo solo informativo, no consta en la tabla.
    private $estado;
    private $baseImponible;
    private $baseNoImponible;
    private $valorIva;
    private $total;
    public function getIdFacturaCab() {
        return $this->idFacturaCab;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getNombresCliente() {
        return $this->nombresCliente;
    }

    public function getDireccionCliente() {
        return $this->direccionCliente;
    }

    public function setNombresCliente($nombresCliente) {
        $this->nombresCliente = $nombresCliente;
    }

    public function setDireccionCliente($direccionCliente) {
        $this->direccionCliente = $direccionCliente;
    }

        public function getEstado() {
        return $this->estado;
    }

    public function getBaseImponible() {
        return $this->baseImponible;
    }

    public function getBaseNoImponible() {
        return $this->baseNoImponible;
    }

    public function getValorIva() {
        return $this->valorIva;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setIdFacturaCab($idFacturaCab) {
        $this->idFacturaCab = $idFacturaCab;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setBaseImponible($baseImponible) {
        $this->baseImponible = $baseImponible;
    }

    public function setBaseNoImponible($baseNoImponible) {
        $this->baseNoImponible = $baseNoImponible;
    }

    public function setValorIva($valorIva) {
        $this->valorIva = $valorIva;
    }

    public function setTotal($total) {
        $this->total = $total;
    }


}
