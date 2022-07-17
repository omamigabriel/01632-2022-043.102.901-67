<?php  

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    private $view = array();

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        // $this->load->library('session');
        // $this->load->library('ControleSessao');
        //$sessao = new ControleSessao();
    }

    public function index()
    { 
        // $log = array('nav' => $this->input->get("nav"),);
        // $this->session->set_userdata($log);
        $this->load->template('home', 'home/home', $this->view);
    }

    public function home() 
    {
        $this->load->view("home");
    }

}