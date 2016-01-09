<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* Récupère les éléments de menu, dans l'ordre */
function menu_items()
{
	$CI =& get_instance();
	return $CI->db->query("SELECT Text, Link FROM menu_items ORDER BY Position ASC")->result();
}


/* End of file menu_helper.php */
/* Location: ./application/helpers/menu_helper.php */