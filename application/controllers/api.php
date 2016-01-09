<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class API extends CI_Controller {
/* API (Application Programming Interface) : Permet de traiter des requêtes AJAX */



	public function __construct()
	{
		parent::__construct();
	}



	# Récupération de news
	public function news()
	{
		$start = intval($this->input->get('start'));
		$length = intval($this->input->get('length'));
		if($length == 0) $length = 10;
		
		$this->load->model('news_model');
		
		list($year, $month) = $this->news_model->format_year_month($this->input->get('year'), $this->input->get('month'));
		$news = $this->news_model->get_all_news($start, $length, $year, $month);
		
		if(!empty($news)) foreach($news as $N) $this->load->view('news/single', array('X' => $N));
		else echo "<END>";
	}
	
	
	
	private function f($n)
	{
		if($n <= 2) return 1;
		else return $this->f($n - 2) + $this->f($n - 1);
	}
	
	
	
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */