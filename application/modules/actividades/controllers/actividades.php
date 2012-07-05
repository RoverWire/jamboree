<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividades extends Controller {

	public function __construct()
	{
		parent::Controller();
		$this->load->model('actividad');
		$this->template->write_view('sidebar', 'sidebar');
	}

	public function index()
	{
		$this->actividad->consultar('', 0, 15);
		$config['base_url']   = '#';
		$config['total_rows'] = $this->actividad->total_registros;
		$config['per_page']   = 15;
		$config['cur_page']   = 0; 
		$this->pagination->initialize($config);
		
		$this->template->add_js('js/jquery.ajaxify.min.js');
		$this->template->add_js('js/jquery.simplemodal.js');
		$this->template->add_js('js/jquery.zebragrid.js');
		$this->template->add_js('js/jquery.gritter.min.js');
		$this->template->add_css('temas/registro/css/jquery.gritter.css');
		$this->template->write('content', '<h1 class="titulo_seccion">Actividades</h1>');
		$this->template->write_view('content', 'consulta');
		$this->template->render();
	}

	public function grid()
	{
		$b = array();
		$c = array();
		$datos = array();
		if($this->input->post('eliminar')){
			$this->actividad->eliminar($this->input->post('Del'));
		}
		
		if($this->input->post('offset') != ''){
			$offset = (int)trim($this->input->post('offset'));
		}else{
			$offset = 0;
		}
		
		if($this->input->post('buscar')){
			$b[$this->input->post('campo')] = $this->input->post('buscar');
			$c[0] = $this->input->post('criterio');
		}
		$datos['offset'] = $offset;
		$this->actividad->consultar($b, $offset, 15, $c, '', '', '');
		$this->load->view('grid', $datos);
	}

	public function grid_pagination($offset = 0, $total = 0)
	{
		$config['base_url']   = '#';
		$config['total_rows'] = $total;
		$config['per_page']   = 15;
		$config['cur_page']   = $offset; 
		$this->pagination->initialize($config);
		echo $this->pagination->create_links();
	}

	public function nueva()
	{
		if ($_POST) 
		{
			$datos = $this->input->post('Datos');
			$this->form_validation->set_error_delimiters('<span class="error-form">', '</span>');
			$this->form_validation->set_rules('Datos[nombre]', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('Datos[capacidad]', 'Capacidad', 'required|integer|trim');
			$this->form_validation->set_rules('Datos[tipo]', 'Tipo', 'required|trim');
			if ($this->form_validation->run()) 
			{
				if($this->actividad->agregar($this->input->post('Datos')))
				{
					$msg['title'] = 'Actividad Agregada';
					$msg['text']  = sprintf('La actividad %s ha sido añadida a las actividades del evento.', $datos['nombre']);
					$msg['image'] = relative_root('img/checkmark_64.png');
					$dialog = jgritter_script($msg);
					$this->session->set_flashdata('extrascript', $dialog);
					redirect('actividades');
				}	
			}
		}
		else
		{
			$datos = $this->actividad->arreglo_campos();
		}
		$this->template->write('content', '<h1 class="titulo_seccion">Agregar actividad nueva</h1>');
		$this->template->write_view('content', 'form', $datos);
		$this->template->add_js('js/jquery.uniform.js');
		$this->template->render();
	}

	public function editar($id)
	{
		if($_POST)
		{
			$datos = $this->input->post('Datos');
			$this->form_validation->set_error_delimiters('<span class="error-form">', '</span>');
			$this->form_validation->set_rules('Datos[nombre]', 'Nombre', 'required|trim');
			$this->form_validation->set_rules('Datos[capacidad]', 'Capacidad', 'required|integer|trim');
			$this->form_validation->set_rules('Datos[tipo]', 'Tipo', 'required|trim');
			if ($this->form_validation->run())
			{
				if($this->actividad->actualizar($id, $this->input->post('Datos')))
				{
					$msg['title'] = 'Actividad Actualizada';
					$msg['text']  = sprintf('La actividad %s ha sido actualizada en el listado del sistema.', $datos['nombre']);
					$msg['image'] = relative_root('img/checkmark_64.png');
					$dialog = jgritter_script($msg);
					$this->session->set_flashdata('extrascript', $dialog);
					redirect('actividades');
				}
			}
		}
		else
		{
			$c = array('id' => $id);
			$this->actividad->consultar($c, 0, 1);
			$datos = $this->actividad->datos[0];
		}
		$this->template->write('content', '<h1 class="titulo_seccion">Editar datos de actividad</h1>');
		$this->template->write_view('content', 'form', $datos);
		$this->template->add_js('js/jquery.uniform.js');
		$this->template->render();
	}

}

/* End of file actividades.php */
/* Location: ./application/controllers/actividades.php */