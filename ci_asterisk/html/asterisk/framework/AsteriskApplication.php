<?php

class AsteriskApplication extends Application
{
    protected $login_action = array('account', 'signin');

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    public function registerRoutes()
    {
        return array(
            //StatusControllerのほかのルーティング
            '/user/:user_name'
                => array('controller' => 'status', 'action' => 'user'),
            '/user/:user_name/status/:id'
                => array('controller' => 'status', 'action' => 'show'),

            //AccountControllerのルーティング
            '/'                 => array('controller' => 'status', 'action' => 'index'),
            '/status/post'      => array('controller' => 'status', 'action' => 'post'),

            '/account'          => array('controller' => 'account', 'action' => 'index'),
            '/account/:action'  => array('controller' => 'account'),

            '/follow'           => array('controller' => 'account', 'action' => 'follow'),

        );
    }

    protected function configure()
    {
        $this->db_manager->connect('master', array(
            'dns'       => 'mysql:dbname=asterisk;host=localhost',
            'user'      => 'test',
            'password'  => 'testtest',
        ));
    }
}