<?php
class Login_session {
  const LOGGED_IN = 'logged_in';
  const USER_ID = 'user_id';
  const USER_NAME = 'name';
  const BUSYO_ID = 'busyo_id';
  protected $CI;

  public function __construct(){
    $this->CI =& get_instance();
    $this->CI->load->library('session');
  }

  public function is_logged_in(){
    return $this->CI->session->userdata(self::LOGGED_IN); 
  }

  public function get_user_id(){
    return $this->CI->session->userdata(self::USER_ID);
  }

  public function get_busyo_id(){
    return $this->CI->session->userdata(self::BUSYO_ID);
  }

  public function get_user_name(){
    return $this->CI->session->userdata(self::USER_NAME);
  }

  public function login($data){
    $this->CI->session->set_userdata(self::LOGGED_IN, TRUE);
    $this->CI->session->set_userdata($data);
  }

  public function logout(){
    $this->CI->session->sess_destroy();
  }
}


