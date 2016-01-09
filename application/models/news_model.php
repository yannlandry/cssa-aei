<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {
/* Modèle pour les nouvelles */



	# Formatte l'année et le mois
	public function format_year_month($year, $month)
	{
		$year = intval($year);
		$month = intval($month);
		
		if($month > 0 && $month <= 12 && $year > 0 && $year <= 9999) return array($year, $month);
		else return array(0, 0);
	}
	
	
	
	# Récupérer toutes les nouvelles
	public function get_all_news($start = 0, $length = 10, $year = 0, $month = 0)
	{
		$criteria = $month > 0 && $year > 0 ? "WHERE Creation BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-31 23:59:59'" : "";
		return $this->db->query("SELECT ArticleID, Title, UserID, Lead, Introduction, Content, Image FROM articles $criteria ORDER BY ArticleID DESC LIMIT ?,?", array(abs($start),abs($length)))->result();
	}
	
	
	
	# Récupérer les nouvelles
	public function get_side_news($start = 0, $length = 6)
	{
		return $this->db->query("SELECT ArticleID, Title, UserID, Lead, Introduction, Content, Image FROM articles ORDER BY ArticleID DESC LIMIT ?,?", array($start,$length))->result();
	}
	
	
	
	# Récupérer un seul article
	public function get_one_news($id)
	{
		if(empty($id)) return false;
		
		$Q = $this->db->query("SELECT A.ArticleID, A.Title, A.UserID, U.Username, U.UsualName, A.Lead, A.Content, A.Creation FROM (SELECT ArticleID, Title, UserID, Lead, Content, Creation FROM articles AS A WHERE ArticleID = ? LIMIT 1) AS A LEFT JOIN users AS U ON U.UserID = A.UserID LIMIT 1", array($id));
		
		if($Q->num_rows == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Retourne les mois pour lesquels il y a des nouvelles
	public function get_archives_dates()
	{
		return $this->db->query("SELECT DISTINCT YEAR(Creation) AS Y, MONTH(Creation) AS M FROM articles ORDER BY Y DESC, M DESC")->result();
	}
	
	
	
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */