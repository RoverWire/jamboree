<?php
class registros extends Controller{
	public function __construct()
	{
		parent::Controller();
		$this->load->model('regnal/miembro');
		$this->load->model('registro');
		$this->load->model('campos/campo');
		$this->load->model('campos/manada');
		$this->template->write('sidebar', '<li><a href="'.ruta('registros').'"><span class="icon_lateral icon_registro"></span><u>Nuevo Equipo</u> <br /><small>agregar nuevos equipos</small></a></li>');
		$this->template->write('sidebar', '<li><a href="'.ruta('registros/preregistro').'"><span class="icon_lateral icon_buscar"></span><u>Equipo Preregistrado</u> <br /><small>buscar por cum de scouter</small></a></li>');
	}
	
	public function index()
	{
		if($_POST)
		{
			$this->form_validation->set_error_delimiters('<span class="error-form">', '</span>');
			$this->form_validation->set_rules('scouter', 'CUM Scouter', 'trim|required|exact_length[10]|xss_clean|scout_vigente|nivel_valido|pago_evento|scouter_registrado');
			$this->form_validation->set_rules('lobato[0]', 'Elemento 1',  'trim|required|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			$this->form_validation->set_rules('lobato[1]', 'Elemento 2',  'trim|required|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			$this->form_validation->set_rules('lobato[2]', 'Elemento 3',  'trim|required|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			$this->form_validation->set_rules('lobato[3]', 'Elemento 4',  'trim|required|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			
			if($_POST['lobato'][4] != ''){
				$this->form_validation->set_rules('lobato[4]', 'Elemento 5',  'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}
			
			if($_POST['lobato'][5] != ''){
				$this->form_validation->set_rules('lobato[5]', 'Elemento 5',  'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');

			}
			if($_POST['lobato'][6] != ''){
				$this->form_validation->set_rules('lobato[6]', 'Elemento 7', 'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}

			if($_POST['lobato'][7] != ''){
				$this->form_validation->set_rules('lobato[7]', 'Elemento 8', 'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}

			if($_POST['lobato'][8] != ''){
				$this->form_validation->set_rules('lobato[8]', 'Elemento 9', 'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}

			if($_POST['lobato'][9] != ''){
				$this->form_validation->set_rules('lobato[9]', 'Elemento 10', 'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}

			if($_POST['lobato'][10] != ''){
				$this->form_validation->set_rules('lobato[10]', 'Elemento 11', 'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}

			if($_POST['lobato'][11] != ''){
				$this->form_validation->set_rules('lobato[11]', 'Elemento 12', 'trim|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
			}
			
			if($this->form_validation->run())
			{
				if($this->registro->seisena_nueva($this->input->post('scouter'), $this->input->post('lobato')))
				{
					redirect('actividades/asignar/'.$this->input->post('scouter'));
				}
			}
		}
		
		$this->template->add_js('js/jquery.gritter.min.js');
		$this->template->add_css('temas/registro/css/jquery.gritter.css');
		$this->template->add_js('js/jquery.uniform.js');
		
		$this->template->write('content', '<h1 class="titulo_seccion">Nuevo Equipo</h1>');
		$this->template->write_view('content', 'nuevo');
		$this->template->render();	
	}
	
	public function ficha($cum = '')
	{
		if(empty($cum) && strlen($cum) != 10)
		{
			redirect('registros');
		}
		
		$this->registro->detalles($cum);
		$this->template->write_view('content', 'ficha');
		$this->template->render();
	}
	
	public function paso2($cum = '')
	{
		if(empty($cum) && strlen($cum) != 10)
		{
			redirect('registros');
		}
		
		$this->registro->detalles($cum);
		$this->template->write_view('content', 'detalles');
		$this->template->render();
	}
	
	public function paso3($cum = '', $campo = '')
	{
		if(empty($cum) OR strlen($cum) != 10)
		{
			redirect('registros');
		}
		
		if($_POST)
		{
			$this->form_validation->set_rules('asignado', 'Comunidad', 'trim|required|xss_clean');
			if($this->form_validation->run()){
				$this->registro->borrar_asignacion($cum);
				$this->registro->asignar_manada($cum, $this->input->post('asignado'));
				redirect('registros/ubicacion/'.$cum);
			}
		}
		
		if(empty($campo) OR !is_numeric($campo)){
			$campo = 1;
		}
		
		
		$this->template->add_js('js/jquery.zebragrid.js');
		$this->template->write('content', '<h1 class="titulo_seccion">Asignar Comunidad</h1>');
		$this->campo->consultar();
		$this->template->write_view('content', 'campos');
		$this->campo->liberar_resultados();
		$C = array('idcampo' => $campo);
		$this->campo->consultar($C, 0, 1);
		$this->template->write('content', '<h2>'.$this->campo->nombre.'</h2>');
		$this->manada->manada_seisenas($campo);
		$dato = array('cum' => $cum);
		$this->template->write_view('content', 'manadas', $dato);
		$this->template->render();
	}
	
	public function ubicacion($cum = '')
	{
		if(empty($cum) OR strlen($cum) != 10)
		{
			redirect('registros');
		}
		
		$this->campo->ubicacion($cum);
		$this->template->write_view('content', 'ubicacion');
		$this->template->render();
	}
	
	public function preregistro()
	{
		$this->template->add_js('js/jquery.gritter.min.js');
		$this->template->add_css('temas/registro/css/jquery.gritter.css');
		$this->template->add_js('js/jquery.uniform.js');
		$this->template->write('content', '<h1 class="titulo_seccion">Buscar Equipo Preregistrado</h1>');
		$this->template->write_view('content', 'registrado');
		$this->template->render();
	}
	
	public function scouter()
	{
		$error = array();
		$this->form_validation->set_rules('cum', 'CUM', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run())
		{
			if($this->registro->registrado($this->input->post('cum'))){
				$error['noerror'] = strtoupper($this->input->post('cum'));
			}else{
				$error['cum'] = 'El CUM no se encuentra registrado en el evento.';
			}
		}
		else
		{
			$error['cum'] = form_error('cum');
		}
		echo json_encode($error);
	}
	
	public function cambiar_scouter($cum)
	{
		$this->template->add_js('js/jquery.gritter.min.js');
		$this->template->add_css('temas/registro/css/jquery.gritter.css');
		$this->template->add_js('js/jquery.uniform.js');
		
		$this->template->write('content', '<h1 class="titulo_seccion">Cambio de Scouter Responsable</h1>');
		$datos = array('cum' => $cum);
		$this->template->write_view('content', 'cambio', $datos);
		$this->template->render();
	}
	
	public function cambio_scouter()
	{
		$error = array();
		$this->form_validation->set_rules('cum', 'CUM', 'trim|required|exact_length[10]|xss_clean|scout_vigente|nivel_valido|pago_evento|scouter_registrado');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run())
		{
			if($this->registro->cambio_scouter($this->input->post('anterior'), $this->input->post('cum'))){
				$error['noerror'] = strtoupper($this->input->post('cum'));
			}else{
				$error['cum'] = 'No se pudo realizar el cambio.';
			}
		}
		else
		{
			$error['cum'] = form_error('cum');
		}
		echo json_encode($error);
	}
	
	public function modificar($cum)
	{
		if(empty($cum) OR strlen($cum) != 10)
		{
			redirect('registros');
		}
		
		if($_POST)
		{
			if($_POST['cum'])
			{
				$this->form_validation->set_error_delimiters('<span class="error-form">', '</span>');
				$this->form_validation->set_rules('cum', 'CUM',  'trim|required|exact_length[10]|xss_clean|scout_vigente|pago_evento|lobato_registrado');
				if($this->form_validation->run())
				{
					$this->registro->agregar_lobato($cum, $this->input->post('cum'));
					redirect('registros/modificar/'.$cum);
				}
			}
			
			if($_POST['eliminar'])
			{
				$this->registro->eliminar_lobato($this->input->post('Del'));
				redirect('registros/modificar/'.$cum);
			}
		}
		
		
		$this->template->add_js('js/jquery.gritter.min.js');
		$this->template->add_css('temas/registro/css/jquery.gritter.css');
		$this->template->add_js('js/jquery.uniform.js');
		$this->template->add_js('js/jquery.zebragrid.js');
		
		$this->template->write('content', '<h1 class="titulo_seccion">Modificar Equipo</h1>');
		$this->registro->detalles($cum);
		$this->template->write_view('content', 'modificar');
		
		$this->template->render();
	}
}