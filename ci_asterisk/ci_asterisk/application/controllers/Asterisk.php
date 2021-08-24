<?php
class Asterisk extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('asterisk_model');
		$this->load->helper('url_helper');
		$this->load->helper('html');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('login_session');
	}

	public function index()
	{
		$data['sys_data'] = $this->asterisk_model->get_sys_data();
		$data['sys_data'] = $this->load->view('asterisk/var', $data, TRUE);
		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/index');
	}

	public function bangou($id = FALSE)
	{
		$post = $this->input->post();
		if(!empty($post['touroku']))
		//if(!empty($this->input->post('touroku')))
		{
			$this->form_validation->set_rules('touroku_bangou', 'Bangou', 'required');
			if($this->form_validation->run() === TRUE)
			{
				if($this->asterisk_model->set_bangou())
				{
					$data['model'] = TRUE;
					$data['message'] = '電話番号の登録が完了しました。';
				}
				else
				{
					$data['model'] = FALSE;
					$data['message'] = '電話番号の登録が失敗しました。';
				}
			}
			else
			{
				$data['model'] = FALSE;
				$data['message'] = '電話番号を入力して下さい。';
			}
		}

		if(!empty($post['update']))
		//if(!empty($this->input->post('update')))
		{
			if(!$this->asterisk_model->update_bangou())
			{
				$data['model'] = TRUE;
				$data['message'] = '番号の情報の上書を完了しました。';
			}
			else
			{
				$data['model'] = FALSE;
				$data['message'] = '番号の情報の上書が失敗しました。';
			}
		}

		$data['data'] = $this->asterisk_model->get_phone_data($id);
		$data['title'] = '電話番号情報';

		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/bangou');
		$this->load->view('asterisk/col');
	}

	public function cdr()
	{
		if($this->input->post('cdr') === '発呼情報')
		{
			$from = 'src';
			$to = 'dst';
		}
		else
		{
			$from = 'dst';
			$to = 'src';
		}

		$data['title'] = $from;

		$end = (!empty($this->input->post('end'))) ? date('Y-m-d 23:59:59', strtotime($this->input->post('end'))) : date('Y-m-d 23:59:59');
		$data['post'] = array(
			'from' => $from,
			'to' => $to,
			'daihyou' => $this->input->post('daihyou'),
			'start' => $this->input->post('start'),
			'end' => $end
		);
		$data['data'] = $this->asterisk_model->get_cdr($data['post']);
		$data['hour_calls'] = $this->asterisk_model->get_hour_calls($data['post']);
		if($this->input->post())
		{
			$data['model'] = TRUE;
			$data['message'] = '検索が完了しました。';
		}

		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/cdr');
	}

	public function admin($logout = FALSE)
	{
		if(!$this->login_session->is_logged_in())
		{
			redirect('asterisk/index');
		}

		if($logout)
		{
			$this->login_session->logout();
			redirect('asterisk/index');
		}

		$post = $this->input->post();
		
		//if(!empty($post['select_dir']))
		//{
	//		$data['title'] = $post['select_dir'];
	//	}

		if(!empty($post['dir']))
		{
			$data['title'] = $post['dir'];
		}
		elseif(!empty($post['select_dir']))
		{
			$data['title'] = $post['select_dir'];
		}
		else
		{
			$data['title'] = 'conf';
		}

		if($data['title'] === 'conf')
		{
			$data['dir'] = glob("/var/www/html/asterisk/conf/*");
		}
		else
		{
			$data['dir'] = glob("/var/www/html/asterisk/tftp/SEP*");
		}

		if(!empty($post['editfile']))
		{
			$data['editfile'] = $post['editfile'];
		}
		if(!empty($post['file']))
		{
			$data['editfile'] = $post['file'];
		}


		if(!empty($post['open']) && !empty($post['file']))
		{
			$data['text'] = $this->asterisk_model->get_text($post['file'], $data['title']);
			$data['model'] = TRUE;
			$data['message'] = $post['file'].'を開きました。';
		}

		if(!empty($post['save']) && !empty($post['editfile']))
		{
			$this->asterisk_model->write_file($post['editfile'], $post['contents'], $post['select_dir']);
			$data['model'] = TRUE;
			$data['message'] = $post['editfile'].'を編集し、asteriskをリロードしました。';
		}

		if(!empty($post['back']))
		{
			$data['files'] = $this->asterisk_model->get_back_file($post['editfile']);
			if(!empty($data['files']))
			{
				$data['model'] = TRUE;
				$data['message'] = $post['editfile'].'のバックアップファイルを表示しました。';
			}
			else
			{
				$data['model'] = FALSE;
				$data['message'] = $post['editfile'].'のバックアップファイルはありません。';

			}
		}

		if(!empty($post['update']))
		{
			if(!empty($post['back_file']))
			{
				if(!$this->asterisk_model->file_update($data['editfile'], $post['back_file']))
				{
					$data['model'] = TRUE;
					$data['message'] = 'バックアップファイルに置き換え、asteriskをリロードしました。';
				}
				else
				{
					$data['model'] = FALSE;
					$data['message'] = 'バックアップファイルの置き換えに失敗しました。';
				}
			}
			else
			{
					$data['model'] = FALSE;
					$data['message'] = 'バックアップファイルを選択してください。';
			}

		}

		if(!empty($post['copy']) && !empty($post['copyname']))
		{
			$this->asterisk_model->copy_file($post['editfile'], $post['copyname']);
			$data['model'] = TRUE;
			$data['message'] = $post['copyname'].'を複製しました。';
		}
	
		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/admin');
	}

	public function var($index = FALSE)
	{
		if(!$this->login_session->is_logged_in())
		{
			redirect('asterisk/index');
		}

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('naiyou', 'Naiyou', 'required');
		
		if(!empty($this->input->post('touroku')))
		{
			if($this->form_validation->run() === TRUE)
			{
				if($this->asterisk_model->set_var())
				{
					$data['model'] = TRUE;
					$data['message'] = '更新情報の登録が完了しました。';
				}
				else
				{
					$data['model'] = FALSE;
					$data['message'] = '更新情報の登録が失敗しました。';
				}
			}
			else
			{
				$data['model'] = FALSE;
				$data['message'] = '名前、または内容が入力されていません。';
				//$data['vali_ms'] = '名前、または内容が入力されていません。';
			}
		}

		$data['sys_data'] = $this->asterisk_model->get_sys_data();

		$this->load->view('templates/header', $data);
		$this->load->view('asterisk/var_form');
		$this->load->view('asterisk/var');

	}
}
?>
