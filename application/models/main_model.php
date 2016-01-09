<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model {
/* Modèle pour les pages principales */



	# Taille des images dans le slider
	const SLIDER_IMAGE_X = 1140;
	const SLIDER_IMAGE_Y = 400;
	const SLIDER_IMAGE_DIR = './uploads/slider';
	
	
	
	# Ajouter une entrée au formulaire de contact
	public function insert_contact()
	{
		$data = array(
			'Name' => htmlspecialchars($this->input->post('name')),
			'Email' => htmlspecialchars($this->input->post('email')),
			'Subject' => htmlspecialchars($this->input->post('subject')),
			'Message' => htmlspecialchars($this->input->post('message')),
			'IP' => get_client_ip()
		);
		
		$this->db->insert('contact', $data);
	}
	
	
	
	# Récupère les images du slider, les redimensionne au besoin
	public function get_slider_images()
	{
		$handle = opendir(self::SLIDER_IMAGE_DIR);
		$return = array();
		
		while(false !== ($entry = readdir($handle))) {
			if(in_array( strtolower(get_file_ext($entry)) , array('jpeg', 'jpg', 'gif', 'png') ) && is_image(self::SLIDER_IMAGE_DIR.'/'.$entry)) {
				list($w, $h) = getimagesize(self::SLIDER_IMAGE_DIR.'/'.$entry);
				if($w == self::SLIDER_IMAGE_X && $h == self::SLIDER_IMAGE_Y)
					$return[] = UPLOADS_URL.'/slider/'.$entry;
				elseif($w > self::SLIDER_IMAGE_X && $h > self::SLIDER_IMAGE_Y)
					$return[] = $this->resize_for_slider($entry);
			}
		}
		
		return $return;
	}
	
	
	
	# Redimensionne une image pour l'ajuster au slider
	private function resize_for_slider($file)
	{
		# Assumons que les fichiers sont des images valides
		$I = create_image_from_file(self::SLIDER_IMAGE_DIR.'/'.$file);
		$I = resize_image($I, self::SLIDER_IMAGE_X, self::SLIDER_IMAGE_Y, true);
		return save_image_to_file($I, self::SLIDER_IMAGE_DIR.'/'.get_file_name($file), get_file_ext($file), 100);
	}
	
	
	
}

/* End of file main_model.php */
/* Location: ./application/models/main_model.php */