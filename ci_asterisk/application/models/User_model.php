<?php
class User_model extends CI_Model
{
        public function __construct(){
                $this->load->database();
        }

        public function can_login()
        {
                $query = $this->db->select('password')
                        ->where('user_id', $this->input->post('user_id'))->get('users');
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
                        'user_id' => $this->input->post('user_id'),
                        'busyo_id' => $this->input->post('busyo_id'),
                        'name' => $this->input->post('name'),
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                        'created_at' => date('Y-m-d'),
                );

                return $this->db->insert('users', $data);
        }

        public function get_user_data()
        {
                $query = $this->db->where('user_id', $this->input->post('user_id'))->get("users");
                $row = $query->row();
                $data = array(
                        'user_id' => $row->user_id,
                        'busyo_id' => $row->busyo_id,
                        'name' => $row->name
                );

                return $data;
        }
}
?>
