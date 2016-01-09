<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {



	private $validfn = false;



	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('main_model');
	}



	public function index()
	{
		$this->load->model('news_model');
		$this->load->model('events_model');
		
		$this->load->view('common/headtag', array('styles' => array('home')));
		$this->load->view('main/home_header', array('pictures' => $this->main_model->get_slider_images()));
		$this->load->view('main/index', array('news' => $this->news_model->get_side_news(0, 4), 'events' => array_slice($this->events_model->get_all_events(), 0, 2)));
		$this->load->view('common/footer', array('scripts' => array('carousel')));
	}
	
	
	
	public function contact()
	{
		$this->load->library('form_validation');
		$this->lang->load('form_validation', 'french');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		
		$this->form_validation->set_rules('name', 'Nom', 'trim|htmlspecialchars');
		$this->form_validation->set_rules('email', 'Adresse courriel', 'trim|valid_email');
		$this->form_validation->set_rules('subject', 'Sujet', 'trim|htmlspecialchars|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|htmlspecialchars|required|min_length[40]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_matches_captcha');
		
		$this->form_validation->set_message('matches_captcha', "Le captcha ne correspond pas.");
		
		$this->validfn = true;
		
		if($this->form_validation->run()) {
			$this->main_model->insert_contact();
			addFlash("Votre message a bien été envoyé. Nous nous efforcerons de répondre dans les plus brefs délais !");
			redirect(base_url());
		}
		
		else {
			$this->load->helper('captcha');
			$captcha = create_captcha(array(
				'img_path' => './assets/captchas/',
				'img_url' => ASSETS_URL.'/captchas/',
				'font_path' => './assets/fonts/junkos.ttf'
			));
			$_SESSION['captcha'] = $captcha['word'];
			
			$this->load->helper('form');
			$this->load->view('common/headtag');
			$this->load->view('common/header', array('headerTitle' => "Contact"));
			$this->load->view('main/contact', array('captcha' => $captcha['image']));
			$this->load->view('common/footer', array('scripts' => array('autosize')));
		}
	}
	
		# Captcha correspond
		public function matches_captcha($input)
		{
			if(!$this->validfn) show_404(); # Empêche l'exécution de cette méthode par accès direct
			return isset($_SESSION['captcha']) && strtoupper($input) == strtoupper($_SESSION['captcha']);
		}



	# Page de connexion
	public function login()
	{
		if(User::is_connected()) redirect(base_url('/admin'));
		$this->load->view('admin/login');
	}
	
	
	
	# Méthode de déconnexion
	public function logout()
	{
		$this->sessions->logout();
		redirect(base_url());
	}
	
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */