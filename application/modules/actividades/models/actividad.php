<?php
class Actividad extends MY_Model{

	public $nombre;
	public $tipo;
	public $capacidad;
	
	public function __construct()
	{
		parent::MY_Model();
		$this->tabla['nombre']     = 'actividades';
		$this->tabla['campoclave'] = 'id';
		$this->tabla['campos']     = array('id', 'nombre', 'tipo', 'capacidad');
	}
}