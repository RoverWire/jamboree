<?php
class campos extends Controller{
	public function __construct()
	{
		parent::Controller();
	}
	
	public function index()
	{
		$this->template->render();
	}
}