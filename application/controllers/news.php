<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('news_model');
	}
	
	
	
	# Affichage de toutes les nouvelles
	public function index($year = 0, $month = 0)
	{
		# Rendu du bloc news
		list($year, $month) = $this->news_model->format_year_month($year, $month);
		$news = $this->news_model->get_all_news(0, 10, $year, $month);
		$render = "";
		foreach($news as $N) $render.= $this->load->view('news/single', array('X' => $N), true);
		
		$headerTitle = "Nouvelles";
		if($year > 0 && $month > 0) $headerTitle.= ' <small>'.fr_month($month).' '.$year.'</small>';
		
		# Affichage
		$this->load->view('common/headtag', array('pageTitle' => "Nouvelles"));
		$this->load->view('common/header', array('headerTitle' => $headerTitle));
		$this->load->view('news/index', array(	'news' => $render,
												'infscr' => array(
													'base_url' => BASE_URL,
													'year' => $year,
													'month' => $month
												),
												'archives' => $this->news_model->get_archives_dates(),
												'year' => $year,
												'month' => $month
										)	);
		$this->load->view('common/footer', array('scripts' => array('infscr')));
	}



	# Visionnement d'une nouvelle
	public function view($id)
	{
		$N = $this->news_model->get_one_news($id);
		if($N === FALSE) show_404();
		
		# Affichage
		$this->load->view('common/headtag', array('pageTitle' => $N->Title, 'styles' => array('comments')));
		$this->load->view('common/header', array('headerTitle' => $N->Title, 'headerParagraph' => $N->Lead));
		$this->load->view('news/view', array('N' => $N, 'sidenews' => $this->news_model->get_side_news()));
		$this->load->view('common/footer', array('scripts' => array('facebookSDK'))); # Appel du SDK de Facebook
	}
	
	
	
}

/* End of file news.php */
/* Location: ./application/controllers/news.php */