<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('events_model');
	}



	public function index()
	{
		$this->load->view('common/headtag');
		$this->load->view('common/header', array('headerTitle' => "Événements"));
		$this->load->view('events/index', array('events' => $this->events_model->get_all_events()));
		$this->load->view('common/footer');
	}
	
	
	
	public function view($id = 0)
	{
		$E = $this->events_model->get_event($id);
		if($E === FALSE) show_404();
		
		$this->load->view('common/headtag');
		$this->load->view('common/header', array('headerTitle' => $E->name, 'headerParagraph' => frdate($E->start_time, true, strpos($E->start_time, ':') === FALSE, true, true)));
		$this->load->view('events/view', array('E' => $E));
		$this->load->view('common/footer');
	}
	
	
	
}

/* End of file events.php */
/* Location: ./application/controllers/events.php */