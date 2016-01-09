<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* Retourne le premier paramètre non-vide */
function coalesce()
{
	foreach(func_get_args() as $arg)
		if(!empty($arg))
			return $arg;
	return NULL;
}


/* Retourne le mois, en français */
function fr_month($index)
{
	$index = intval($index);
	$m = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
	if(array_key_exists($index - 1, $m)) return $m[$index - 1];
	else return false;
}


/* Retourne le jour de la semaine, en français */
function fr_weekday($index)
{
	$index = intval($index);
	$d = array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
	if(array_key_exists($index - 1, $d)) return $d[$index - 1];
	else return false;
}


/* Renvoie une date lisible */
function frdate($input = NULL, $absdate = false, $exclude_hrs = false, $adjust_time = true, $no_acronym = false)
{
	# Transformation de l'input
	$T = !is_numeric($input) ? strtotime($input) : intval($input);
	if($T === FALSE) return $input;
	unset($input);
	
	# Maintenant
	$now = time();
	
	# Application des ajustements
	if($adjust_time) {
		if(defined('CSDATE_SERVER_ADJUST')) $now+= intval(CSDATE_SERVER_ADJUST) * 3600;
		if(defined('CSDATE_DATABASE_ADJUST')) $T+= intval(CSDATE_DATABASE_ADJUST) * 3600;
	}
	
	# Différence de temps
	$diff = $now - $T;
	
	# Génération de la date absolue
	$date = date('j', $T).' '.fr_month(date('n'), $T).' '.date('Y', $T);
	$hour = date('H:i', $T);
	
	# Here we go...
	$display = '';
	
	if(!$absdate && $diff < 518400) {
		# Affichage "à l'instant"
		if($diff < 10)
			$display = "à l'instant";
		
		# Affichage d'un intervalle
		elseif($diff < 86400) {
			$display = 'il y a ';
			if($diff < 60)			$display.= $diff.' secondes';
			elseif($diff < 3600)	$display.= intval($diff / 60).' '.($diff < 120 ? 'minute' : 'minutes');
			else					$display.= intval($diff / 3600).' '.($diff < 7200 ? 'heure' : 'heures');
		}
		
		# Affichage d'un jour de semaine
		else {
			$display = fr_weekday(date('N', $T));
			if(!$exclude_hrs) $display.= ' à '.$hour;
		}
	}
	
	# Affchage simple de la date
	else {
		$display = 'le ' . $date;
		if(!$exclude_hrs) $display.= ' à '.$hour;
	}
	
	return ($no_acronym?'':'<acronym title="'.$date.' à '.$hour.'" class="time">').$display.($no_acronym?'':'</acronym>');
}


/* Récupère l'adresse IP du client */
function get_client_ip()
{
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];

	if(filter_var($client, FILTER_VALIDATE_IP))
		$IP = $client;
	elseif(filter_var($forward, FILTER_VALIDATE_IP))
		$IP = $forward;
	else
		$IP = $remote;

	return $IP;
}


/* Insère un champ caché qui contient le jeton CSRF de l'utilisateur */
function insert_csrf_token()
{
	echo '<input type="hidden" name="csrf_token" value="'.User::csrf_token().'" />';
}


/* Confirme et valide le jeton de sécurité de l'utilisateur */
function check_csrf_token($token = NULL)
{
	$CI =& get_instance();
	if(coalesce($CI->input->post('csrf_token'), $CI->input->get('csrf_token'), $token) != User::csrf_token()) {
		addFlash("Votre jeton de sécurité est invalide. Veuillez réessayer.", 'danger');
		return false;
	}
	else return true;
}


/* End of file misc_helper.php */
/* Location: ./application/helpers/misc_helper.php */