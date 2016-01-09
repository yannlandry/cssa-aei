<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {



	private $validfn = false;



	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->helper('admin');
		
		if(!User::is_connected()) redirect(base_url('/login'));
	}
	
	
	
	private function kick_users()
	{
		if(!User::is_admin()) show_404();
	}
	
	
	
	public function index()
	{
		return $this->news();
	}
	
	
	
	public function news()
	{
		$page = get_page();
		$count = $this->admin_model->count_news();
		$news = $this->admin_model->get_news(($page - 1) * 20, 20);
		
		# Pagination
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => base_url('/admin/nouvelles'),
			'cur_page' => $page,
			'total_rows' => $count,
			'per_page' => 20
		));
		$pagination = $this->pagination->create_links();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Nouvelles", 'pageTitle' => "Nouvelles"));
		$this->load->view('admin/news', array('news' => $news, 'pagination' => $pagination));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function newnews()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$this->form_validation->set_rules('title', "Titre", 'trim|required|htmlspecialchars|min_length[3]');
		$this->form_validation->set_rules('lead', "Introduction", 'trim|htmlspecialchars');
		$this->form_validation->set_rules('content', "Contenu", 'trim|required|xss_clean|min_length[50]');
		
		if($this->form_validation->run() && check_csrf_token()) {
			$this->admin_model->create_news();
			addFlash("La nouvelle a été enregistrée.");
			redirect(base_url('/admin/nouvelles'));
		}
		
		else {
			$this->load->view('admin/common/header', array('headerTitle' => "Écrire une nouvelle", 'pageTitle' => "Écrire une nouvelle"));
			$this->load->view('admin/write');
			$this->load->view('admin/common/footer', array('scripts' => array('tinymce', 'autosize')));
		}
	}
	
	
	
	public function editnews($id = 0)
	{
		$N = $this->admin_model->get_news_edit($id);
		if($N === FALSE) {
			addFlash("Cette nouvelle n'existe pas.", 'danger');
			redirect(base_url('/admin/nouvelles'));
		}
		elseif(!User::id($N->UserID) && !User::is_admin()) {
			addFlash("Vous n'avez pas le droit d'éditer cette nouvelle car elle ne vous appartient pas.", 'danger');
			redirect(base_url('/admin/nouvelles'));
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$this->form_validation->set_rules('title', "Titre", 'trim|required|htmlspecialchars|min_length[3]');
		$this->form_validation->set_rules('lead', "Introduction", 'trim|htmlspecialchars');
		$this->form_validation->set_rules('content', "Contenu", 'trim|required|xss_clean|min_length[50]');
		
		if($this->form_validation->run() && check_csrf_token()) {
			$this->admin_model->edit_news($N->ArticleID);
			addFlash("La nouvelle a été sauvegardée.");
			redirect(base_url('/admin/nouvelles'));
		}
		
		else {
			$PR = array('title' => $N->Title,
						'lead' => $N->Lead,
						'content' => $N->Content);
			
			$this->load->view('admin/common/header', array('headerTitle' => "Éditer une nouvelle", 'headerSmall' => '&laquo; '.$N->Title.' &raquo;', 'pageTitle' => "Éditer une nouvelle"));
			$this->load->view('admin/write', array('PR' => $PR));
			$this->load->view('admin/common/footer', array('scripts' => array('tinymce', 'autosize')));
		}
	}
	
	
	
	public function deletenews($id = 0)
	{
		$N = $this->admin_model->get_news_delete($id);
		
		if($N === FALSE)
			addFlash("Cette nouvelle n'existe pas.", 'danger');
		elseif(!User::id($N->UserID) && !User::is_admin())
			addFlash("Vous n'avez pas le droit de supprimer cette nouvelle car elle ne vous appartient pas.", 'danger');
		elseif(isset($_POST['conf-yes']) && check_csrf_token()) {
			$this->admin_model->delete_news($N->ArticleID);
			addFlash("La nouvelle a été supprimée.");
		}
		elseif(isset($_POST['conf-no'])) {
			# Rien
		}
		else {
			$this->request_confirmation("Voulez-vous vraiment supprimer cette nouvelle ?");
			return true;
		}
		
		redirect(base_url('/admin/nouvelles'));
	}
	
	
	
	public function pages()
	{
		$this->kick_users();
		
		$page = get_page();
		$count = $this->admin_model->count_pages();
		$pages = $this->admin_model->get_pages(($page - 1) * 20, 20);
		
		# Pagination
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => base_url('/admin/pages'),
			'cur_page' => $page,
			'total_rows' => $count,
			'per_page' => 20
		));
		$pagination = $this->pagination->create_links();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Pages", 'pageTitle' => "Pages"));
		$this->load->view('admin/pages', array('pages' => $pages, 'pagination' => $pagination));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function newpage()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$this->form_validation->set_rules('title', "Titre", 'trim|required|htmlspecialchars|min_length[3]');
		$this->form_validation->set_rules('slug', "Adresse", 'trim|required|callback_format_slug|is_unique[pages.Slug]');
		$this->form_validation->set_rules('lead', "Introduction", 'trim|htmlspecialchars');
		$this->form_validation->set_rules('content', "Contenu", 'trim|required|xss_clean');
		
		$this->validfn = true;
		
		if($this->form_validation->run() && check_csrf_token()) {
			$this->admin_model->create_page();
			addFlash("La page a été enregistrée.");
			redirect(base_url('/admin/pages'));
		}
		
		else {
			$this->load->view('admin/common/header', array('headerTitle' => "Créer une page", 'pageTitle' => "Créer une page"));
			$this->load->view('admin/write', array('isPage' => true));
			$this->load->view('admin/common/footer', array('scripts' => array('autosize')));
		}
	}
	
		public function format_slug($slug) {
			if(!$this->validfn) show_404();
			return format_slug($slug);
		}
	
	
	
	public function editpage($id = 0)
	{
		$this->kick_users();
		
		$N = $this->admin_model->get_page_edit($id);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$rule = $this->input->post('title') && $this->input->post('title') != $N->Title ? '|is_unique[pages.Slug]' : '';
		
		$this->form_validation->set_rules('title', "Titre", 'trim|required|htmlspecialchars|min_length[3]');
		$this->form_validation->set_rules('slug', "Adresse", 'trim|required|callback_format_slug'.$rule);
		$this->form_validation->set_rules('lead', "Introduction", 'trim|htmlspecialchars');
		$this->form_validation->set_rules('content', "Contenu", 'trim|required|xss_clean');
		
		$this->validfn = true;
		
		if($this->form_validation->run() && check_csrf_token()) {
			$this->admin_model->edit_page($N->PageID);
			addFlash("La page a été sauvegardée.");
			redirect(base_url('/admin/pages'));
		}
		
		else {
			$PR = array('title' => $N->Title,
						'slug' => $N->Slug,
						'lead' => $N->Lead,
						'content' => $N->Content);
			
			$this->load->view('admin/common/header', array('headerTitle' => "Éditer une page", 'headerSmall' => '&laquo; '.$N->Title.' &raquo;', 'pageTitle' => "Éditer une page"));
			$this->load->view('admin/write', array('PR' => $PR, 'isPage' => true));
			$this->load->view('admin/common/footer', array('scripts' => array('autosize')));
		}
	}
	
		# format_slug se trouve sous la méthode newpage()
	
	
	
	public function deletepage($id = 0)
	{
		$this->kick_users();
		
		$N = $this->admin_model->get_page_delete($id);
		
		if($N === FALSE)
			addFlash("Cette page n'existe pas.", 'danger');
		elseif(isset($_POST['conf-yes']) && check_csrf_token()) {
			$this->admin_model->delete_page($N->PageID);
			addFlash("La page a été supprimée.");
		}
		elseif(isset($_POST['conf-no'])) {
			# Rien
		}
		else {
			$this->request_confirmation("Voulez-vous vraiment supprimer cette page ?");
			return true;
		}
		
		redirect(base_url('/admin/pages'));
	}
	
	
	
	public function menu()
	{
		$this->kick_users();
		
		if($this->admin_model->update_menu())
			addFlash("Le menu a été mis à jour.");
		
		$menu = $this->admin_model->get_menu();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Menu", 'headerParagraph' => "Gérez les éléments du menu horizontal.", 'pageTitle' => "Menu"));
		$this->load->view('admin/menu', array('menu' => $menu));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function slideshow()
	{
		$this->kick_users();
		
		if($this->input->get('delete') && check_csrf_token() && @unlink('./uploads/slider/'.$this->input->get('delete')))
			addFlash("La diapositive a été supprimée.");
		
		if($this->admin_model->try_upload_slide())
			addFlash("La diapositive a été mise en ligne.");
		
		$slides = $this->admin_model->get_slides();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Diaporama", 'headerParagraph' => "Gérez les éléments du diaporama sur la page d'accueil.", 'pageTitle' => "Diaporama"));
		$this->load->view('admin/slideshow', array('slides' => $slides));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function messages()
	{
		$this->kick_users();
		
		$page = get_page();
		$count = $this->admin_model->count_messages();
		$messages = $this->admin_model->get_messages(($page - 1) * 10, 10);
		
		# Pagination
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => base_url('/admin/messages'),
			'cur_page' => $page,
			'total_rows' => $count,
			'per_page' => 10
		));
		$pagination = $this->pagination->create_links();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Messages", 'headerParagraph' => "Voici tous les messages qui ont été envoyés depuis le formulaire de contact.", 'pageTitle' => "Messages"));
		$this->load->view('admin/messages', array('messages' => $messages, 'pagination' => $pagination));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function accounts()
	{
		$this->kick_users();
		
		$page = get_page();
		$count = $this->admin_model->count_accounts();
		$accounts = $this->admin_model->get_accounts(($page - 1) * 20, 20);
		
		# Pagination
		$this->load->library('pagination');
		$this->pagination->initialize(array(
			'base_url' => base_url('/admin/comptes'),
			'cur_page' => $page,
			'total_rows' => $count,
			'per_page' => 20
		));
		$pagination = $this->pagination->create_links();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Comptes", 'pageTitle' => "Comptes"));
		$this->load->view('admin/accounts', array('accounts' => $accounts, 'pagination' => $pagination));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function newaccount()
	{
		$this->kick_users();
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$this->form_validation->set_rules('username', "Nom d'utilisateur", 'trim|required|htmlspecialchars|min_length[6]|is_unique[users.Username]');
		$this->form_validation->set_rules('password', "Mot de passe", 'required|min_length[6]');
		$this->form_validation->set_rules('usualname', "Nom usuel", 'trim|htmlspecialchars');
		$this->form_validation->set_rules('isadmin', "Droits", 'required');
		
		if($this->form_validation->run() && check_csrf_token()) {
			$this->admin_model->create_account();
			addFlash("Le compte a été créé.");
			redirect(base_url('/admin/comptes'));
		}
		
		else {
			$this->load->view('admin/common/header', array('headerTitle' => "Créer un compte", 'pageTitle' => "Créer un compte"));
			$this->load->view('admin/editaccount', array('isEdit' => true));
			$this->load->view('admin/common/footer');
		}
	}
	
	
	
	public function editaccount($id)
	{
		$this->kick_users();
		
		$A = $this->admin_model->get_account_edit($id);
		if($A === FALSE) {
			addFlash("Ce compte n'existe pas.", 'danger');
			redirect(base_url('/admin/comptes'));
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$rule = $this->input->post('username') && $this->input->post('username') != $A->Username ? '|is_unique[users.Username]' : '';
		
		$this->form_validation->set_rules('username', "Nom d'utilisateur", 'trim|required|htmlspecialchars|min_length[6]'.$rule);
		$this->form_validation->set_rules('password', "Mot de passe", 'min_length[6]');
		$this->form_validation->set_rules('usualname', "Nom usuel", 'trim|htmlspecialchars');
		$this->form_validation->set_rules('isadmin', "Droits", 'required');
		
		if($this->form_validation->run() && check_csrf_token()) {
			if(User::id($id) && $this->input->post('isadmin') == 'false')
				$_POST['isadmin'] == true;
		
			$this->admin_model->edit_account($A->UserID);
			addFlash("Le compte a été sauvegardé.");
			redirect(base_url('/admin/comptes'));
		}
		
		else {
			$PR = array('username' => $A->Username,
						'usualname' => $A->UsualName,
						'isadmin' => $A->IsAdmin);
			
			$this->load->view('admin/common/header', array('headerTitle' => "Modifier un compte", 'pageTitle' => "Modifier un compte"));
			$this->load->view('admin/editaccount', array('isEdit' => true, 'PR' => $PR));
			$this->load->view('admin/common/footer');
		}
	}
	
	
	
	public function deleteaccount($id = 0)
	{
		$this->kick_users();
		
		$A = $this->admin_model->get_account_delete($id);
		
		if($A === FALSE)
			addFlash("Ce compte n'existe pas.", 'danger');
		elseif(isset($_POST['conf-yes']) && check_csrf_token()) {
			$this->admin_model->delete_account($A->UserID);
			addFlash("Le compte a été supprimé.");
		}
		elseif(isset($_POST['conf-no'])) {
			# Rien
		}
		else {
			$this->request_confirmation("Souhaitez-vous vraiment supprimer ce compte ?");
			return true;
		}
		
		redirect(base_url('/admin/comptes'));
	}
	
	
	
	public function pictures()
	{
		# Essayons de mettre une image en ligne
		if($this->admin_model->try_upload_picture())
			addFlash("Image mise en ligne.");
		
		$pictures = $this->admin_model->get_pictures();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Images", 'headerParagraph' => "Cliquez sur une image pour afficher plus d'options.", 'pageTitle' => "Images"));
		$this->load->view('admin/pictures', array('pictures' => $pictures));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function deletepicture($file)
	{
		if(!file_exists('./uploads/images/'.$file))
			addFlash("Cette image n'existe pas.", 'danger');
		elseif(substr($file, 0, strlen(User::id()) + 1) != User::id()."_")
			addFlash("Vous ne pouvez pas supprimer cette image car elle ne vous appartient pas.", 'danger');
		elseif(isset($_POST['conf-yes']) && check_csrf_token()) {
			unlink('./uploads/images/'.$file);
			addFlash("L'image a été supprimée.");
		}
		elseif(isset($_POST['conf-no'])) {
			# Rien
		}
		else {
			$this->request_confirmation("Souhaitez-vous vraiment supprimer cette image ?");
			return true;
		}
		
		redirect(base_url('/admin/images'));
	}
	
	
	
	public function files()
	{
		$this->kick_users();
		
		# Redirection vers l'upload d'image, le cas échéant
		if($this->admin_model->has_uploaded_image()) {
			addFlash("Vous avez envoyé une image. Par conséquent, celle-ci a été transférée dans le dossier approprié.", 'warning');
			$this->pictures();
			return false;
		}
		
		if($this->admin_model->try_upload_file())
			addFlash("Fichier mis en ligne.");
		
		$files = $this->admin_model->get_files();
		
		$this->load->view('admin/common/header', array('headerTitle' => "Fichiers", 'headerParagraph' => "Cliquez sur un fichier pour afficher plus d'options.", 'pageTitle' => "Fichiers"));
		$this->load->view('admin/files', array('files' => $files));
		$this->load->view('admin/common/footer');
	}
	
	
	
	public function deletefile($file)
	{
		$this->kick_users();
		
		$file = urldecode($file);
		if(!file_exists('./uploads/files/'.$file))
			addFlash("Ce fichier n'existe pas.", 'danger');
		elseif(isset($_POST['conf-yes']) && check_csrf_token()) {
			unlink('./uploads/files/'.$file);
			addFlash("Le fichier a été supprimé.");
		}
		elseif(isset($_POST['conf-no'])) {
			# Rien
		}
		else {
			$this->request_confirmation("Souhaitez-vous vraiment supprimer ce fichier ?");
			return true;
		}
		
		redirect(base_url('/admin/fichiers'));
	}
	
	
	
	public function myaccount()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<li>", "</li>");
		$this->lang->load('form_validation', 'french');
		
		$this->form_validation->set_rules('newpass', "Nouveau mot de passe", 'required|min_length[6]');
		$this->form_validation->set_rules('confpass', "Confirmez le mot de passe", 'required|matches[newpass]');
		$this->form_validation->set_rules('oldpass', "Ancien mot de passe", 'required|callback_matches_old_password');
		
		$this->form_validation->set_message('matches_old_password', "Votre ancien mot de passe est incorrect.");
		
		if($this->form_validation->run() && check_csrf_token()) {
			$this->admin_model->change_my_password();
			addFlash("Votre mot de passe a été changé.");
			redirect(base_url('/admin/moncompte'));
		}
		
		else {
			$this->load->view('admin/common/header', array('headerTitle' => "Mon compte", 'headerParagraph' => "Utilisez ce formulaire pour changer votre mot de passe.", 'pageTitle' => "Mon compte"));
			$this->load->view('admin/myaccount');
			$this->load->view('admin/common/footer');
		}
	}
	
		function matches_old_password($password)
		{
			$P = $this->admin_model->get_my_password();
			return hash('sha512', $P->Pre.$password.$P->Post) == $P->Password;
		}
	
	
	
	# Demande de confirmation
	private function request_confirmation($text = "")
	{
		$this->load->view('admin/common/header', array('headerTitle' => "Confirmation", 'pageTitle' => "Confirmation"));
		$this->load->view('admin/confirm', array('text' => $text));
		$this->load->view('admin/common/footer');
	}
	
	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */