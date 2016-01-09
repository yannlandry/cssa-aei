<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Classe Users, utilise les sessions natives de PHP pour gérer les utilisateurs */

class Sessions {
	
	
	public function __construct()
	{
		session_start();
		
		
		$CI =& get_instance();
		
		
		# Cas 1 : Déjà connecté, vérification des sessions
		if($this->is_connected()):
			$R = $CI->db->query("SELECT UserID, Username, Password, UsualName, IsAdmin FROM users WHERE UserID = ? LIMIT 1", array($_SESSION['id']))->row();
			if($_SESSION['id'] == $R->UserID && $_SESSION['password'] == $R->Password && $_SESSION['ip'] == $this->get_client_ip()) {
				# Sessions pour la page suivante
				$_SESSION['id'] = $R->UserID;
				$_SESSION['password'] = $R->Password;
				$_SESSION['ip'] = $this->get_client_ip();
				# Autres informations
				global $USINFO;
				$USINFO = array(
					'Username' => $R->Username,
					'UsualName' => $R->UsualName,
					'IsAdmin' => $R->IsAdmin
				);
			}
			else {
				$this->logout();
				addFlash("Vos identifiants de session sont invalides. Vous avez été déconnecté par mesure de sécurité.", 'danger');
				$this->redirect_to_login();
			}
		
		
		# Cas 2 : Non-connecté, mais des variables POST pour la connexion sont présentes
		elseif(isset($_POST['log_username'], $_POST['log_password'])):
			$R = $CI->db->query("SELECT UserID, Username, Password, PasswordPreSalt, PasswordPostSalt, UsualName, IsAdmin FROM users WHERE Username = ? LIMIT 1",
					array(trim($_POST['log_username'])))->row();
			if(hash('sha512', $R->PasswordPreSalt.$_POST['log_password'].$R->PasswordPostSalt) == $R->Password) {
				# Sessions pour la page suivante
				$_SESSION['id'] = $R->UserID;
				$_SESSION['password'] = $R->Password;
				$_SESSION['ip'] = $this->get_client_ip();
				$_SESSION['csrf_token'] = uniqid(NULL, true);
				# Autres informations
				global $USINFO;
				$USINFO = array(
					'Username' => $R->Username,
					'UsualName' => $R->UsualName,
					'IsAdmin' => $R->IsAdmin
				);
				if(isset($_POST['keep-me-in'])) {
					setcookie('aefsum_id', $R->UserID, time() + 3600 * 24 * 30);
					setcookie('aefsum_pass', $R->Password, time() + 3600 * 24 * 30);
				}
			}
			else {
				addFlash("Vos identifiants sont incorrects.", 'danger');
				$this->redirect_to_login();
			}
		
		
		# Cas 3 : Non-connecté, mais des cookies de connexion sont présents
		elseif(isset($_COOKIE['aefsum_id'], $_COOKIE['aefsum_pass'])):
			$Q = $CI->db->query("SELECT UserID, Username, Password, UsualName, IsAdmin FROM users WHERE UserID = ? AND Password = ? LIMIT 1",
					array($_COOKIE['aefsum_id'], $_COOKIE['aefsum_pass']));
			if($Q->num_rows() == 1) {
				$R = $Q->row();
				unset($Q);
				# Sessions pour la page suivante
				$_SESSION['id'] = $R->UserID;
				$_SESSION['password'] = $R->Password;
				$_SESSION['ip'] = $this->get_client_ip();
				$_SESSION['csrf_token'] = uniqid(NULL, true);
				# Autres informations
				global $USINFO;
				$USINFO = array(
					'Username' => $R->Username,
					'UsualName' => $R->UsualName,
					'IsAdmin' => $R->IsAdmin
				);
			}
			else
				$this->destroy_autoconnect();
		
		
		# Cas 4 : Session vierge
		else:
			$this->set_blank_session();
		
		
		endif;
	}
	
	
	
	public function is_connected()
	{
		# On vérifie les variables principales, les autres étant simplement réinitialisées sur demande
		return !empty($_SESSION['id']) && !empty($_SESSION['password']);
	}
	
	
	
	public function logout($goto = NULL)
	{
		if($this->is_connected()) {
			# On crée/modifie quelques sessions pour le bon fonctionnement
			$this->set_blank_session();
			
			# Destruction des cookies de connexion automatique
			$this->destroy_autoconnect();
		}
	}
	
	
	
	public function set_blank_session()
	{
		# On crée quelques variables de session pour le bon fonctionnement
		$_SESSION['id'] = 0;
		$_SESSION['password'] = NULL;
	}
	
	
	
	public function redirect_to_login()
	{
		redirect(base_url('/login'));
	}
	
	
	
	public function destroy_autoconnect()
	{
		setcookie('aefsum_id', '', 0);
		setcookie('aefsum_pass', '', 0);
	}


	public function get_client_ip()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			return $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			return $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			return $_SERVER['REMOTE_ADDR'];
		else
			return 'UNKNOWN';
	}
	
	
}
// END Sessions Class

/* End of file Sessions.php */
/* Location: ./application/libraries/Sessions.php */