<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('usuario');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {

        if (!empty($this->session->id_usuario)) {
            redirect(base_url("Home"));
        } else {
            $this->load->view('login');
        }
    }

    public function validar_login() { 
        $email = $this->input->post_get('nume_matricula');
        $senha = $this->input->post_get('codi_senha');
        $retorno = $this->usuario->validar_login($email, md5($senha)); 
       
        if (!empty($retorno)) {
            foreach ($retorno as $r) {
                $nome = $r->nome;
                $email = $r->email;
                $id_usuario = $r->id_usuario;
            }
        } else {
            $nome = "";
            $email = "";
            $id_usuario = "";
        }
       
        if (empty($id_usuario) ) {
            $retorno = "erro";
        } else {
            $log = array(
                'nome' => $nome,
                'email' => $email,
                'id_usuario' => $id_usuario
            );
            $this->session->set_userdata($log);
            $retorno = true;
            
        }

        die (json_encode($retorno, true));
    }

    public function ajax_redirect($location = '') { 

        $location = $this->input->post('location'. '');
        $location = empty($location) ? '/' : $location;
        if (strpos($location, '/') !== 0 || strpos($location, '://') !== false) {
            if (!function_exists('base_url')) {
                $this->load->helper('url');
            }

            $location = base_url($location);
        }
        $script = "window.location='{$location}';";
        $this->output->enable_profiler(false)
                ->set_content_type('application/x-javascript')
                ->set_output($script);
    }

    public function logout() {
        if(!empty($this->session->id_usuario)){
            $this->session->sess_destroy();
        }
        redirect(base_url());
    }
}