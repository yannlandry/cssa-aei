<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {
/* Modèle pour charger les pages */
	
	
	
	# Lire une page
	public function get_page($slug)
	{
		if(empty($slug)) return false;
		
		$Q = $this->db->query("SELECT Title, Lead, Content, LastUpdate FROM pages WHERE Slug = ? LIMIT 1", array($slug));
		
		if($Q->num_rows == 0) return false;
		else return $Q->row();
	}
	
	
	
}

/* End of file pages_model.php */
/* Location: ./application/models/pages_model.php */