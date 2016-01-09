<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
/* Modèle gérant une partie de l'administration */



	/****************
	 * SECTION NEWS *
	 ****************/
	
	
	
	# Compter les news
	public function count_news()
	{
		if(User::is_admin()) return $this->db->count_all('articles');
		return $this->db->query("SELECT COUNT(ArticleID) AS Count FROM articles WHERE UserID = ?", array(User::id()))->row()->Count;
	}
	
	
	
	# Retourner les news
	public function get_news($start = 0, $length = 20)
	{
		$addon = User::is_admin() ? NULL : "WHERE UserID = ".User::id();
		return $this->db->query("SELECT ArticleID, Title, Lead, Introduction, Creation FROM articles $addon ORDER BY ArticleID DESC LIMIT ?,?", array($start, $length))->result();
	}
	
	
	
	# Enregistrer une news
	public function create_news()
	{
		$data = array(	'Title' => $this->input->post('title'),
						'Lead' => $this->input->post('lead'),
						'Introduction' => character_limiter(strip_tags($this->input->post('content')), 230),
						'Content' => $this->input->post('content'),
						'Image' => detect_image($this->input->post('content')),
						'UserID' => User::id());
		
		$this->db->insert('articles', $data);
	}
	
	
	
	# Récupérer une news pour l'édition
	public function get_news_edit($id = 0)
	{
		if(empty($id)) return false;
		
		$Q = $this->db->query("SELECT ArticleID, UserID, Title, Lead, Content FROM articles WHERE ArticleID = ? LIMIT 1", array($id));
		
		if($Q->num_rows() == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Sauvegarder une news après édition
	public function edit_news($id)
	{
		$data = array(	'Title' => $this->input->post('title'),
						'Lead' => $this->input->post('lead'),
						'Introduction' => character_limiter(strip_tags($this->input->post('content')), 230),
						'Content' => $this->input->post('content'),
						'Image' => detect_image($this->input->post('content')));
		
		$this->db->where('ArticleID', $id);
		$this->db->update('articles', $data);
	}
	
	
	
	# Récupérer une news pour la suppression
	public function get_news_delete($id = 0)
	{
		if(empty($id)) return false;
		
		$Q = $this->db->query("SELECT ArticleID, UserID FROM articles WHERE ArticleID = ? LIMIT 1", array($id));
		
		if($Q->num_rows() == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Supprimer une news
	public function delete_news($id = 0)
	{
		$this->db->where('ArticleID', $id);
		$this->db->delete('articles');
	}



	/*****************
	 * SECTION PAGES *
	 *****************/
	
	
	
	# Compter les pages
	public function count_pages()
	{
		return $this->db->count_all('pages');
	}
	
	
	
	# Retourner les pages
	public function get_pages($start = 0, $length = 20)
	{
		return $this->db->query("SELECT PageID, Slug, Title, Lead, LastUpdate FROM pages ORDER BY Slug ASC", array($start, $length))->result();
	}
	
	
	
	# Enregistrer une page
	public function create_page()
	{
		#$this->load->helper('htmLawed');
		
		$data = array(	'Title' => $this->input->post('title'),
						'Slug' => $this->input->post('slug'),
						'Lead' => $this->input->post('lead'),
						'Content' => $this->input->post('content'));
		
		$this->db->insert('pages', $data);
	}
	
	
	
	# Récupérer une page pour l'édition
	public function get_page_edit($id = 0)
	{
		if(empty($id)) return false;
		
		$Q = $this->db->query("SELECT PageID, Slug, Title, Lead, Content FROM pages WHERE PageID = ? LIMIT 1", array($id));
		
		if($Q->num_rows() == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Sauvegarder une page après édition
	public function edit_page($id)
	{
		$data = array(	'Title' => $this->input->post('title'),
						'Slug' => $this->input->post('slug'),
						'Lead' => $this->input->post('lead'),
						'Content' => $this->input->post('content'));
		
		$this->db->where('PageID', $id);
		$this->db->update('pages', $data);
	}
	
	
	
	# Récupérer une page pour la suppression
	public function get_page_delete($id = 0)
	{
		if(empty($id)) return false;
		
		$Q = $this->db->query("SELECT PageID FROM pages WHERE PageID = ? LIMIT 1", array($id));
		
		if($Q->num_rows() == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Supprimer une page
	public function delete_page($id = 0)
	{
		$this->db->where('PageID', $id);
		$this->db->delete('pages');
	}



	/****************
	 * SECTION MENU	*
	 ****************/
	
	
	
	public function get_menu()
	{
		return $this->db->query("SELECT MenuItemID, Position, Text, Link FROM menu_items ORDER BY Position ASC")->result();
	}
	
	
	
	public function update_menu()
	{
		if(isset($_POST['menu']) && is_array($_POST['menu']) && check_csrf_token()) {
			foreach($_POST['menu'] as $MenuItemID => $M) {
				if($MenuItemID == 'new' && $M['Text'] && $M['Link'] && $M['Position'])
					$this->db->insert('menu_items', array('Text' => $M['Text'], 'Link' => $M['Link'], 'Position' => $M['Position']));
				elseif(isset($M['Delete'])) {
					$this->db->where('MenuItemID', $MenuItemID);
					$this->db->delete('menu_items');
				}
				else {
					$this->db->where('MenuItemID', $MenuItemID);
					$this->db->update('menu_items', array('Text' => $M['Text'], 'Link' => $M['Link'], 'Position' => $M['Position']));
				}
			}
			
			return true;
		}
		
		else return false;
	}



	/*********************
	 * SECTION DIAPORAMA *
	 *********************/
	
	
	
	public function try_upload_slide()
	{
		if(!isset($_FILES['file'])) return false;
		
		$F =& $_FILES['file'];
		
		if(!check_csrf_token())
			return false;
		if($F['error'] != UPLOAD_ERR_OK) {
			addFlash("Erreur lors de l'envoi de l'image (code ".$F['error']."). Veuillez réessayer.", 'danger');
			return false;
		}
		if($F['size'] > 10000000) { # Taille > 10 Mo
			addFlash("Le fichier envoyé est trop lourd. Réduisez sa taille puis réessayez.", 'danger');
			return false;
		}
		if( !in_array( strtolower(get_file_ext($F['name'])) , array('jpeg', 'jpg', 'gif', 'png') ) || !is_image($F['tmp_name']) ) {
			addFlash("Format de fichier incorrect.", 'danger');
			return false;
		}
		
		$filename = time();
		
		list($w, $h) = getimagesize($F['tmp_name']);
		if($w > 1140 || $h > 400) {
			$I = create_image_from_file($F['tmp_name'], get_file_ext($F['name']));
			$I = resize_image($I, 1140, 400, true);
			save_image_to_file($I, "./uploads/slider/$filename", get_file_ext($F['name']), 100);
			return true;
		}
		else {
			move_uploaded_file($F['tmp_name'], "./uploads/slider/$filename.".get_file_ext($F['name']));
			return true;
		}
	}
	
	
	
	public function get_slides()
	{
		$dir = './uploads/slider';
		$handle = opendir($dir);
		$return = array();
		
		while(false !== ($entry = readdir($handle)))
			if(in_array( strtolower(get_file_ext($entry)) , array('jpeg', 'jpg', 'gif', 'png') ) && is_image("$dir/$entry")) $return[] = $entry;
		
		return $return;
	}



	/********************
	 * SECTION MESSAGES *
	 ********************/
	
	
	
	# Compte tous les messages
	public function count_messages()
	{
		return $this->db->count_all('contact');
	}
	
	
	
	# Compte les nouveaux messages
	public function count_new_messages()
	{
		return $this->db->query("SELECT COUNT(ContactID) AS Count FROM contact WHERE New = 1")->row()->Count;
	}
	
	
	
	# Renvoie les messages
	public function get_messages($start = 0, $length = 10)
	{
		$messages = $this->db->query("SELECT ContactID, Name, Email, Subject, Message, Sent, IP, New FROM contact ORDER BY ContactID DESC LIMIT ?,?", array($start, $length))->result();
		
		$mark = array();
		foreach($messages as $M)
			if($M->New == 1) $mark[] = intval($M->ContactID);
		if(!empty($mark)) $this->db->query("UPDATE contact SET New = 0 WHERE ContactID IN (".implode(',', $mark).")");
		
		return $messages;
	}



	/*******************
	 * SECTION COMPTES *
	 *******************/
	
	
	
	# Compte tous les comptes
	public function count_accounts()
	{
		return $this->db->count_all('users');
	}
	
	
	
	# Récupère les comptes
	public function get_accounts($start = 0, $length = 20)
	{
		return $this->db->query("SELECT UserID, Username, UsualName, IsAdmin FROM users ORDER BY IsAdmin DESC, Username ASC LIMIT ?,?", array($start, $length))->result();
	}
	
	
	
	# Crée un compte
	public function create_account()
	{
		$data = array(	'Username' => $this->input->post('username'),
						'UsualName' => $this->input->post('usualname'),
						'IsAdmin' => $this->input->post('isadmin') == 'true' ? 1 : 0,
						'PasswordPreSalt' => generate_salt(),
						'PasswordPostSalt' => generate_salt());
		$data['Password'] = hash('sha512', $data['PasswordPreSalt'].$this->input->post('password').$data['PasswordPostSalt']);
		
		$this->db->insert('users', $data);
	}
	
	
	
	public function get_account_edit($id = 0)
	{
		if($id == 0) return false;
		
		$Q = $this->db->query("SELECT UserID, Username, UsualName, IsAdmin FROM users WHERE UserID = ?", array($id));
		
		if($Q->num_rows == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Modifie un compte
	public function edit_account($id)
	{
		$data = array(	'Username' => $this->input->post('username'),
						'UsualName' => $this->input->post('usualname'),
						'IsAdmin' => $this->input->post('isadmin') == 'true' ? 1 : 0);
		
		if($this->input->post('password')) {
			$data['PasswordPreSalt'] = generate_salt();
			$data['PasswordPostSalt'] = generate_salt();
			$data['Password'] = hash('sha512', $data['PasswordPreSalt'].$this->input->post('password').$data['PasswordPostSalt']);
		}
		
		$this->db->where('UserID', $id);
		$this->db->update('users', $data);
	}
	
	
	
	# Récupérer un compte pour la suppression
	public function get_account_delete($id = 0)
	{
		if(empty($id)) return false;
		
		$Q = $this->db->query("SELECT UserID FROM users WHERE UserID = ? LIMIT 1", array($id));
		
		if($Q->num_rows() == 0) return false;
		else return $Q->row();
	}
	
	
	
	# Supprimer un compte
	public function delete_account($id)
	{
		$this->db->where('UserID', $id);
		$this->db->delete('users');
	}



	/******************
	 * SECTION IMAGES *
	 ******************/
	
	
	
	# Récupère les images de l'utilisateur
	public function get_pictures()
	{
		$prefix = User::id()."_";
		$dir = './uploads/images';
		$handle = opendir($dir);
		$return = array();
		
		while(false !== ($entry = readdir($handle))) {
			if(	(substr($entry, 0, strlen($prefix)) == $prefix || User::is_admin()) # Image appartenant à l'utilisateur
				&& substr_count($entry, "_") == 1 # Image originale
				&& in_array( strtolower(get_file_ext($entry)) , array('jpeg', 'jpg', 'gif', 'png') ) # Extension
				&& is_image($dir.'/'.$entry)) # Type image
					$return[] = $entry;
		}
		
		sort($return);
		return $return;
	}
	
	
	
	# Tente de mettre une image en ligne
	public function try_upload_picture()
	{
		if(!isset($_FILES['file'])) return false;
		
		$F =& $_FILES['file'];
		
		if(!check_csrf_token())
			return false;
		if($F['error'] != UPLOAD_ERR_OK) {
			addFlash("Erreur lors de l'envoi de l'image (code ".$F['error']."). Veuillez réessayer.", 'danger');
			return false;
		}
		if($F['size'] > 10000000) { # Taille > 10 Mo
			addFlash("Le fichier envoyé est trop lourd. Réduisez sa taille puis réessayez.", 'danger');
			return false;
		}
		if( !in_array( strtolower(get_file_ext($F['name'])) , array('jpeg', 'jpg', 'gif', 'png') ) || !is_image($F['tmp_name']) ) {
			addFlash("Format de fichier incorrect.", 'danger');
			return false;
		}
		
		$filename = User::id()."_".time();
		
		list($w, $h) = getimagesize($F['tmp_name']);
		if($w > 750 || $h > 2500) {
			$I = create_image_from_file($F['tmp_name'], get_file_ext($F['name']));
			$I = resize_image($I, 750, 2500, false);
			save_image_to_file($I, "./uploads/images/$filename", get_file_ext($F['name']), 100);
			return true;
		}
		else {
			move_uploaded_file($F['tmp_name'], "./uploads/images/$filename.".get_file_ext($F['name']));
			return true;
		}
	}



	/********************
	 * SECTION FICHIERS *
	 ********************/
	
	
	
	# Vérifie si on vient d'envoyer une image
	public function has_uploaded_image()
	{
		return isset($_FILES['file']) && in_array(strtolower(get_file_ext($_FILES['file']['name'])), array('jpeg', 'jpg', 'gif', 'png')) && is_image($_FILES['file']['tmp_name']);
	}
	
	
	
	# Tente d'envoyer un fichier
	public function try_upload_file()
	{
		if(!isset($_FILES['file'])) return false;
		
		$F =& $_FILES['file'];
		
		if(!check_csrf_token())
			return false;
		if($F['error'] != UPLOAD_ERR_OK) {
			addFlash("Erreur lors de l'envoi du fichier. Veuillez réessayer.", 'danger');
			redirect(base_url('/admin/fichiers'));
		}
		if($F['size'] > 20000000) { # Taille > 20 Mo
			addFlash("Le fichier envoyé est trop lourd. Réduisez sa taille puis réessayez.", 'danger');
			redirect(base_url('/admin/fichiers'));
		}
		if($F['name'][0] == "." || $F['name'][strlen($F['name']) - 1] == ".") {
			addFlash("Le nom du fichier ne doit ni débuter ni se terminer par un point. Renommez-le puis réessayez.", 'danger');
			redirect(base_url('/admin/fichiers'));
		}
		
		$filename = preg_replace("# #", "_", get_file_name($F['name']));
		$filext = get_file_ext($F['name']);
		
		$appendix = 0;
		while( file_exists('./uploads/files/'.$filename.($appendix?'-'.$appendix:'').'.'.$filext) ) ++$appendix;
		
		if($appendix) $filename.= "-".$appendix;
		
		move_uploaded_file($F['tmp_name'], "./uploads/files/$filename.$filext");
		return true;
	}
	
	
	
	# Récupère la liste des fichiers
	public function get_files() {
		$dir = './uploads/files';
		$handle = opendir($dir);
		$return = array();
		
		while(false !== ($entry = readdir($handle))) {
			if($entry[0] != '.' && $entry[strlen($entry - 1)] != '.')
				$return[] = $entry;
		}
		
		sort($return);
		return $return;
	}



	/**********************
	 * SECTION MON COMPTE *
	 **********************/
	
	
	
	public function get_my_password()
	{
		return $this->db->query("SELECT Password, PasswordPreSalt AS Pre, PasswordPostSalt AS Post FROM users WHERE UserID = ? LIMIT 1", array(User::id()))->row();
	}
	
	
	
	public function change_my_password()
	{
		$data = array(	'PasswordPreSalt' => generate_salt(),
						'PasswordPostSalt' => generate_salt());
		$data['Password'] = hash('sha512', $data['PasswordPreSalt'].$this->input->post('newpass').$data['PasswordPostSalt']);
		
		$this->db->where('UserID', User::id());
		$this->db->update('users', $data);
		
		$_SESSION['password'] = $data['Password'];
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */