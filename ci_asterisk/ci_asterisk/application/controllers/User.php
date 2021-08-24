<?php
class User extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');

		$this->load->model('user_model');
		$this->load->library('login_session');

	}

	public function index(){
		redirect('/user/login');
	}

	public function add(){
		$this->load->view('templates/header');
		$this->load->view('user/add');
		$this->load->view('templates/footer');
	}

	public function login(){
	$this->form_validation->set_rules('name', 'ユーザ', 'required');
	$this->form_validation->set_rules('password', 'パスワード', 'required');

	if($this->form_validation->run()){
		if($this->user_model->can_login()){
			$data = $this->user_model->get_user_data();
			$this->login_session->login($data);
			redirect('admin');
		}else{
			$data['model'] = FALSE;
			$data['message'] = 'ログインの認証に失敗しました。';
			$this->load->view('templates/header', $data);
			$this->load->view('asterisk/index');
		}
	}else{
		//バリデーションエラー
		$data['model'] = FALSE;
		$data['message'] = 'ユーザまたはパスワードが入力されていません。';
		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/index');
	}
	}

	public function logout(){
		$this->login_session->logout();
		redirect('asterisk/index');
	}

	public function create(){
		if(!$this->login_session->is_logged_in()){
			redirect('asterisk');
		}
		if($this->input->post()){
			//$this->form_validation->set_rules('user_id', 'ユーザーID', 'required|trim|is_unique[users.user_id]');
			$this->form_validation->set_rules('password', 'パスワード', 'required|trim');
			$this->form_validation->set_rules('password_re', 'パスワードの確認', 'required|trim|matches[password]');
			$this->form_validation->set_rules('name', '名前', 'required');
			if($this->form_validation->run()){
			$this->load->model('User_model');
			$this->User_model->register_user();
			
			$data['model'] = TRUE;
			$data['message'] = 'ユーザを登録しました。';

			$this->load->view('templates/header', $data);
			$this->load->view('asterisk/index');
			} else {
				//バリデーションエラー
				//$this->load->model('Busyo_model');
				//$data['busyoArr'] = $this->Busyo_model->get_all_busyo();

				$data['model'] = FALSE;
				$data['message'] = 'ユーザ名・パスワードが入力されていません。';
				$this->load->view('templates/header', $data);
				$this->load->view('asterisk/index');
				//$this->load->view('templates/footer');
			}
		}else{
			//$this->load->model('Busyo_model');
			//$data['busyoArr'] = $this->Busyo_model->get_all_busyo();
			$data['model'] = FALSE;
			$data['message'] = '登録が失敗しました。';
			$this->load->view('templates/header', $data);
			$this->load->view('asterisk/index');
			//$this->load->view('templates/footer');
		}
	}

	public function update(){
		if(!$this->login_session->is_logged_in()){
			redirect('user/login');
		}
		if($this->input->post()){
			$this->form_validation->set_rules('now-name', '現在の名前', 'required|trim');
			$this->form_validation->set_rules('new-name', '新しい名前', 'required|trim');
			$this->form_validation->set_rules('now-pass', '現在のパスワード', 'trim');
			$this->form_validation->set_rules('new-pass1', '新しいのパスワード', 'required|trim');
			$this->form_validation->set_rules('new-pass2', '新しいのパスワードの確認', 'required|trim|matches[new-pass1]');
			if($this->form_validation->run())
			{
				$this->load->model('User_model');
				if($this->User_model->update_user())
				{
					$data['model'] = TRUE;
					$data['message'] = 'ユーザ名とパスワードを変更しました。';
				}
				else
				{
					$data['model'] = FALSE;
					$data['message'] = '現在のユーザ名またはパスワードが間違っています。';
				}
			}
			else
			{
				$data['model'] = FALSE;
				$data['message'] = '全ての項目が入力されていないので、パスワードが変更できませんでした。';
			}
		}
		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/index');
	}
}
?>
