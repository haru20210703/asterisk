<?php
class Asterisk_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function update_bangou()
	{
		$row = $this->input->post();
		foreach($row['id'] as $key => $id)
		{
			$data = array(
				'daihyou' => $row['daihyou'][$key],
				'bangou' => $row['bangou'][$key],
				'address' => $row['address'][$key],
				'bikou' => $row['bikou'][$key]
			);
			$this->db->set($data);
			$this->db->where('id', $id);
			$this->db->update('telephone');
		}

	}

	public function get_phone_data($id = FALSE)
	{
		$this->db->order_by('daihyou');
		$this->db->order_by('bangou');
		$this->db->order_by('address');
		
		if($id === FALSE)
		{
			$query = $this->db->get('telephone');
			return $query->result_array();
		}

		$query = $this->db->get_where('telephone', array('id' => $id));
		return $query->result_array();
	}

	public function get_cdr($data)
	{
		$this->load->helper('date');
		$this->db->where('disposition = "ANSWERED"');
		$this->db->join('telephone', 'cdr.'.$data['from'].' = telephone.bangou');
		$this->db->order_by($data['from'].' ASC, calldate DESC');

		//if(empty($data['end'])) $data['end'] = unix_to_human(now());
		//$data['end'] = date('Y-m-d', nice_date($data['end']));
		
		if(empty($data['daihyou']))
		{

			if(empty($data['start']))
			{
				$query = $this->db->get('cdr');
			}
			else
			{
				$query = $this->db->get_where('cdr', array('start >=' => $data['start'], 'end <=' => $data['end']));
	
			}
		}
		else
		{
			if(empty($data['start']))
			{
				$query = $this->db->get_where('cdr', array('daihyou' => $data['daihyou']));
				//$query = $this->db->get_where('cdr', array($data['from'] => $data['daihyou']));
			}
			else
			{
				$query = $this->db->get_where('cdr', array('daihyou' => $data['daihyou'], 'start >=' => $data['start'], 'end <=' => $data['end']));
				//$query = $this->db->get_where('cdr', array($data['from'] => $data['daihyou'], 'start >=' => $data['start'], 'end <=' => $data['end']));
			}
		}
		return $query->result_array();
	}

	public function set_bangou()
	{
		$data = array(
			'daihyou' => $this->input->post('touroku_daihyou'),
			'bangou' => $this->input->post('touroku_bangou'),
			'address' => $this->input->post('touroku_address'),
			'bikou' => $this->input->post('touroku_bikou')
		);

		return $this->db->insert('telephone', $data);
	}

	public function set_var()
	{
		$data = array(
			'name' => $this->input->post('name'),
			'naiyou' => $this->input->post('naiyou'),
		);

		return $this->db->insert('sys_data', $data);
	}

	public function get_second($start, $end)
	{
		$this->load->helper('date');

		$start = human_to_unix($start);
		$end = human_to_unix($end);
	
		$time = $end - $start;

		return gmdate("H時間i分s秒", $time);

	}

	public function get_call_count($cdr, $daihyou, $start)
	{
		if($daihyou)
		{
		$this->db->select('cdr.start', 'cdr.end', 'cdr.src', 'cdr.dst', 't1.daihyou', 't2.daihyou', 't1.bangou', 't2.bangou');
		$this->db->where('cdr.start <=', $start);
		$this->db->where('cdr.end >=', $start);
		$this->db->where('disposition = "ANSWERED"');
		$this->db->where("(t1.daihyou = '$daihyou' OR t2.daihyou = '$daihyou')");
		$this->db->join('telephone as t1', 't1.bangou = cdr.src', 'left');
		$this->db->join('telephone as t2', 't2.bangou = cdr.dst', 'left');

		$calls = $this->db->count_all_results('cdr');

		switch($calls)
		{
		case 0:
			break;
		case 2:
			return 'text-primary';
		case 3:
			return 'text-success';
		case $calls > 3:
			return 'text-danger';
		}
		}
		else
		{
		
		}
	}

	public function get_hour_calls($data = FALSE)
	{
		$end = $data['end'];

		if(!empty($data['daihyou']))
		{
			$daihyou = $data['daihyou'];
			if(!empty($data['start']))
			{
				$start = $data['start'];
				$query = $this->db->query("select DATE_FORMAT(start, '%H') as start, count(*) as count from cdr 
							left join telephone as t1
							on t1.bangou = cdr.src 
							left join telephone as t2
							on t2.bangou = cdr.dst 
							where disposition = 'ANSWERED' 
							and (t1.daihyou = '$daihyou' or t2.daihyou = '$daihyou') 
							and cdr.start >= '$start' 
							and cdr.end <= '$end' 
							group by DATE_FORMAT(start, '%H')");
			}
			else
			{
				$query = $this->db->query("select DATE_FORMAT(start, '%H') as start, count(*) as count from cdr 
							left join telephone as t1
							on t1.bangou = cdr.src 
							left join telephone as t2
							on t2.bangou = cdr.dst 
							where disposition = 'ANSWERED' 
							and t1.daihyou = '$daihyou' or t2.daihyou = '$daihyou' 
							group by DATE_FORMAT(start, '%H')");
			}
		}
		else
		{
			if(!empty($data['start']))
			{
				$start = $data['start'];
				$query = $this->db->query("select DATE_FORMAT(start, '%H') as start, count(*) as count from cdr	
							where disposition = 'ANSWERED' 
							and start >= '$start' 
							and end <= '$end' 
							group by DATE_FORMAT(start, '%H')");
			}
			else
			{
				$query = $this->db->query("select DATE_FORMAT(start, '%H') as start, count(*) as count from cdr where disposition = 'ANSWERED' group by DATE_FORMAT(start, '%H')");
			}
		}
		return $query->result_array();
	}

	public function get_text($file = FALSE, $dir = FALSE)
	{
		if($dir && $file)
		{
			$file = '/var/www/html/asterisk/'.$dir.'/'.$file;
		}

		$text = file_get_contents($file);
		$text = htmlspecialchars($text);

		return $text;
	}

	public function write_file($editfile = FALSE, $contents, $dir = FALSE)
	{
		if($dir && $editfile)
		{
			$file = '/var/www/html/asterisk/'.$dir.'/'.$editfile;
		}
		$back_file = '/var/www/html/asterisk/back/'.date('Y年m月d日H時i分s秒').$editfile;
		copy($file, $back_file);
		chmod($back_file, 0777);
		$fp = @fopen($file, 'w');

		if($fp)
		{
			log_message('error', $this->session->userdata('name').':ファイル編集:'.$editfile);
			
			fwrite($fp, $contents);
			fclose($fp);
			shell_exec('sh /etc/asterisk/asterisk_reload.sh');
		}
	}

	public function file_update($editfile = FALSE, $back_file, $dir = FALSE)
	{
		if($dir && $editfile)
		{
			$editfile = '/var/www/html/asterisk/'.$dir.'/'.$editfile;
		}
		$back_file = '/var/www/html/asterisk/back/'.$back_file;
		unlink($editfile);
		copy($back_file, $editfile);
		chmod($editfile, 0777);
		shell_exec('sh /etc/asterisk/asterisk_reload.sh');
	}

	public function copy_file($editfile = FALSE, $copyname = FALSE)
	{
		if($copyname && $editfile)
		{
			$editfile = '/var/www/html/asterisk/tftp/'.$editfile;
			$copyname = '/var/www/html/asterisk/tftp/'.$copyname;
		}
		copy($editfile, $copyname);
		chmod($copyname, 0777);
		shell_exec('sh /etc/asterisk/asterisk_reload.sh');
	}

	public function get_back_file($editfile)
	{
		$file = glob('/var/www/html/asterisk/back/*'.$editfile);
		return $file;
	}

	public function get_sys_data()
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('sys_data');
		return $query->result_array();
	}
}
?>
