<?php
/**
 * Description of Cliente
 *
 * @author mrea
 */
class Cliente {
    private $cedula;
    private $apellidos;
    private $nombres;
    private $direccion;
    function __construct($cedula, $apellidos, $nombres, $direccion) {
        $this->cedula = $cedula;
        $this->apellidos = $apellidos;
        $this->nombres = $nombres;
        $this->direccion = $direccion;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }


}
