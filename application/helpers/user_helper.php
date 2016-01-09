<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


abstract class User
{
	// Utilisateur connecté ?
	public function is_connected()
	{
		return !empty($_SESSION['id']) && !empty($_SESSION['password']);
	}
	
	// Renvoie l'ID. Si $id est > 0, compare plutôt l'entier
	public function id($id = 0)
	{
		if(!empty($id)) return $_SESSION['id'] == $id;
		else return $_SESSION['id'];
	}
	
	// Récupère une information de l'utilisateur
	public function info($key)
	{
		if(User::is_connected() && isset($GLOBALS['USINFO'][$key])) return $GLOBALS['USINFO'][$key];
		else return false;
	}
	
	// Renvoie le nom d'utilisateur
	public function name()
	{
		return User::info('Username');
	}
	
	// Renvoie le nom usuel, sinon le nom d'utilisateur
	public function usualname()
	{
		return coalesce(User::info('UsualName'), User::info('Username'));
	}
	
	// Vérifie les droits d'administration
	public function is_admin()
	{
		return User::info('IsAdmin') == 1;
	}

	// Renvoie le jeton CSRF de l'utilisateur
	public function csrf_token()
	{
		if(isset($_SESSION['csrf_token'])) return $_SESSION['csrf_token'];
		else return NULL;
	}
}


/* End of file user_helper.php */
/* Location: ./application/helpers/user_helper.php */