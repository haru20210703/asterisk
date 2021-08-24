<?php
class User_model extends CI_Model
{
        public function __construct(){
                $this->load->database();
        }

        public function can_login()
        {
                $query = $this->db->select('password')
                        ->where('name', $this->input->post('name'))->get('users');
                $row = $query->row();

                if(isset($row)){
                        if(password_verify($this->input->post('password'), $row->password)){
                        return true;
                        }
                }
                return false;
        }

        public function register_user()
        {
                $data = array(
                        //'user_id' => $this->input->post('user_id'),
                        //'busyo_id' => $this->input->post('busyo_id'),
                        'name' => $this->input->post('name'),
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                        //'created_at' => date('Y-m-d'),
                );

                return $this->db->insert('users', $data);
        }

        public function get_user_data()
        {
                $query = $this->db->where('name', $this->input->post('name'))->get("users");
                $row = $query->row();
                $data = array(
                        //'user_id' => $row->user_id,
                        //'busyo_id' => $row->busyo_id,
                        'name' => $row->name
                );

                return $data;
	}

        public function update_user()
        {
		$now_name = $this->input->post('now-name');
                $query = $this->db->select('password')->where('name', $now_name)->get('users');
                $row = $query->row();

                if(isset($row) && password_verify($this->input->post('now-pass'), $row->password))
                //$now_pass = password_hash($this->input->post('now-pass'), PASSWORD_DEFAULT);
		//$query = $this->db->get_where('users', array('name' => $now_name, 'password' => $now_pass));
		//if(!empty($query->result_array()))
		{
			$new_name = $this->input->post('new-name');
                	$password = password_hash($this->input->post('new-pass1'), PASSWORD_DEFAULT);

                	$this->db->set('name', $new_name);
			$this->db->set('password', $password);
			$this->db->where('name', $now_name);
			return $this->db->update('users');
		}
		else
		{
			return FALSE;
		}
        }

}
?>
