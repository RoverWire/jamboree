<?php
class Actividad extends MY_Model{

	public $nombre;
	public $tipo;
	public $capacidad;
	public $ocupacion;
	
	public function __construct()
	{
		parent::MY_Model();
		$this->tabla['nombre']     = 'actividades';
		$this->tabla['campoclave'] = 'id';
		$this->tabla['campos']     = array('id', 'nombre', 'tipo', 'capacidad', 'ocupacion');
	}

	public function combo_equipo($value = '')
	{
		$this->db->select('id, nombre')
				 ->from($this->tabla['nombre'])
				 ->where('tipo', 'Equipo')
				 ->where('ocupacion < capacidad');

		$query = $this->db->get();
		$options = '';

		foreach ($query->result() as $row) {
			$options .= '<option value="'.$row->id.'"';
			$options .= ($row->id == $value) ? ' selected>':'>';
			$options .= $row->nombre.'</option>';
		}

		return $options;

	}

	public function combo_individual($value = '')
	{
		$this->db->select('id, nombre')
				 ->from($this->tabla['nombre'])
				 ->where('tipo', 'Individual')
				 ->where('ocupacion < capacidad');

		$query = $this->db->get();
		$options = '';

		foreach ($query->result() as $row) {
			$options .= '<option value="'.$row->id.'"';
			$options .= ($row->id == $value) ? ' selected>':'>';
			$options .= $row->nombre.'</option>';
		}

		return $options;
	}

	public function asignar($datos)
	{
		if(is_array($datos))
		{
			
		}
	}
}