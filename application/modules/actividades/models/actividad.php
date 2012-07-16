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
			$options .= $row->nombre.'</option>'."\n";
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

	public function asignar($scouter, $grupal, $individual)
	{
		if(is_array($grupal) && is_array($individual) && !empty($scouter))
		{
			$exito = TRUE;
			$this->db->where('(ocupacion + '.count($individual).') < capacidad')->where('id', $grupal['grupal1'])->from($this->tabla['nombre']);
			$result = $this->db->count_all_results();

			if($result){
				$this->db->where('scouter', $scouter)->update('seisenas', array('actividad1' => $grupal['grupal1']));
				$this->db->simple_query("UPDATE actividades SET ocupacion=ocupacion+1 WHERE id=".$grupal['grupal1'].";");
			}else{
				$exito = FALSE;
			}

			$this->db->where('ocupacion + '.count($individual).') < capacidad')->where('id', $grupal['grupal2'])->from($this->tabla['nombre']);
			$result = $this->db->count_all_results();

			if($result){
				$this->db->where('scouter', $scouter)->update('seisenas', array('actividad1' => $grupal['grupal2']));
				$this->db->simple_query("UPDATE actividades SET ocupacion=ocupacion+1 WHERE id=".$grupal['grupal2'].";");
			}else{
				$exito = FALSE;
			}

			$cum = array_keys($individual);
			for($i=0; $i<count($individual); $i++){
				$act = $individual[$cum[$i]];
				$this->db->where('ocupacion < capacidad')->where('id', $act)->from($this->tabla['nombre']);
				$result = $this->db->count_all_results();
				if($result){
					$this->db->simple_query("UPDATE participantes SET actividad='$act' WHERE cum='".$cum[$i]."' LIMIT 1;");
					$this->db->simple_query("UPDATE actividades SET ocupacion=ocupacion+1 WHERE id='$act' LIMIT 1");
				}else{
					$exito = FALSE;
				}
			}

			return $exito;
		}
	}
}