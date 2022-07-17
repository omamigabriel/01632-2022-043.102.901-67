<?php

Class Form_Model extends CI_Model {

    /**
     * Variável que recebe as helpers e libraries default do framework
     * @access protected 
     * @name $CI 
     */
    protected $CI;

    /**
     * Variável que receberá os elementos do formulário 
     * @access private 
     * @name $item 
     * 
     */
    public $item = array();

    /**
     * Função que inicializará a classe carregando em $CI as helpers e libraries necessárias
     * @access public 
     * @return void 
     */
    public $mensagem = null;

    /**
     * Função que inicializará a classe carregando em $CI as helpers e libraries necessárias
     * @access public 
     * @return void 
     */
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->library('form_validation');
    }

    public function addElement($element_form, $item_name, $element_form_paraments) {
        if (!isset($element_form_paraments["name"]))
            $element_form_paraments["name"] = $item_name;
        $this->item[$item_name] = array('element_form' => $element_form, 'element_form_paraments' => $element_form_paraments);

        return;
    }

    public function addAttribute($item_name, $attribute, $value) {
        $item[$item_name]['element_form_paraments'][$attribute] = $value;
        return;
    }

    public function addOptions($item_name, $options) {
        if ($this->item[$item_name]['element_form'] != 'form_dropdown') {
            throw new Exception('O elemento ' . $item_name . ' não é do tipo form_dropdown');

            return false;
        }

        foreach ($options as $key => $value) {
            $this->item[$item_name]['options'][$key] = $value;
        }
        return true;
    }

    public function getElementHtml($item_name) {
        switch ($this->item[$item_name]['element_form']) {
            case 'form_dropdown':
                return call_user_func_array($this->item[$item_name]['element_form'], array(isset($this->item[$item_name]['element_form_paraments']['name']) ? $this->item[$item_name]['element_form_paraments']['name'] : $item_name, $this->item[$item_name]['options'], isset($this->item[$item_name]['default_option']) ? $this->item[$item_name]['default_option'] : '', $this->item[$item_name]['element_form_paraments']));
                break;
            case 'form_hidden':
                if (isset($this->item[$item_name]['element_form_paraments']['value'])) {
                    $paraments = $this->item[$item_name]['element_form_paraments']['value'];
                } else {
                    $paraments = "";
                }
                return call_user_func_array($this->item[$item_name]['element_form'], array($item_name, $paraments));
                break;
            default :
                return call_user_func_array($this->item[$item_name]['element_form'], array($this->item[$item_name]['element_form_paraments']));
                break;
        }
    }

    public function populate($data) {
        $this->CI->form_validation->set_data($data);
        foreach ($data as $key => $value) {
            if (isset($this->item[$key])) {
                if ($this->item[$key]['element_form'] == 'form_dropdown') {
                    $this->item[$key]['default_option'] = $value;
                } else {
                    $this->item[$key]['element_form_paraments']['value'] = $value;
                }
            }
        }
        return;
    }

    public function set_rules($item_name, $label, $rules, $errors = array()) {
        $this->item[$item_name]['validator'] = array("label" => $label, "rules" => $rules, "errors" => $errors);
        return;
    }

    public function validate($bool = false) {
        foreach ($this->item as $key => $item) {

            if (isset($item['validator'])) {
                $this->CI->form_validation->set_rules($key, $item['validator']['label'], $item['validator']['rules'], $item['validator']['errors']);
            }
        }
        if ($this->CI->form_validation->run()) {
            return true;
        } else {
            if ($bool == false) {
                return array("status" => false, "mensagem" => "Por favor, preencha devidamente todos os campos.", "elements" => $this->getErrorsForm());
            } else {
                $this->mensagem = "Por favor, preencha devidamente todos os campos.";
                return false;
            }
        }
    }

    public function getErrorsForm() {
        return $this->CI->form_validation->error_array();
    }

}
