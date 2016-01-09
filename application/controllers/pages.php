<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('pages_model');
	}



	# Visionnement d'une page ; le routage fait arriver le slug de la page via l'URL
	public function view()
	{
		# CodeIgniter divise les sections en paramètres, on les rejoint ici
		$slug = implode('/', func_get_args());
		
		$P = $this->pages_model->get_page($slug);
		if($P === FALSE) show_404();
		
		# Affichage
		$this->load->view('common/headtag', array('pageTitle' => $P->Title));
		$this->load->view('common/header', array('headerTitle' => $P->Title, 'headerParagraph' => $P->Lead));
		$this->load->view('pages/view', array('P' => $P));
		$this->load->view('common/footer');
	}
	
	
	
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */