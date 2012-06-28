<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividades extends Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->template->render();
	}

}

/* End of file actividades.php */
/* Location: ./application/controllers/actividades.php */