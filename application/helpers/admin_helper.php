<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* Fonctionnalités pour l'administration */


# Compte les nouveaux messages
function count_new_messages() 
{
	$CI =& get_instance();
	return $CI->admin_model->count_new_messages();
}


# Détecte une image dans un texte
function detect_image($text)
{
	$offset = 0;
	$search = 'src="'.UPLOADS_URL.'/images/';
	
	while(false !== ($start = strpos($text, $search, $offset))) {
		$end = strpos($text, '"', $start + strlen($search));
		if($end === false) return NULL;
		
		$work = substr($text, $start + 5, $end - $start - 5);
		$work = substr($work, strrpos($work, '/') + 1);
		
		if(preg_match("#^[0-9]+_[a-zA-Z0-9]+\.(jpg|jpeg|gif|png)$#i", $work))
			return $work;
		
		$offset = $pos + 1;
	}
	
	return NULL;
}


# Formatte un slug
function format_slug($slug)
{
	$slug = preg_replace("#[^a-zA-Z0-9/\-_]#", "", $slug);
	$slug = preg_replace("#^/+#", "", $slug);
	$slug = preg_replace("#/+$#", "", $slug);
	return $slug;
}


# Génère un sel d'avant/après mot de passe
function generate_salt()
{
	$salt = "";
	for($i = mt_rand(16,32); $i > 0; --$i)
		$salt.= chr(mt_rand(33,126));
	return $salt;
}


/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */