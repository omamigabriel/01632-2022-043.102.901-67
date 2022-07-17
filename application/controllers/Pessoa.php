<?php  

defined('BASEPATH') or exit('No direct script access allowed');

class Pessoa extends CI_Controller
{

    private $view = array();

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('model_pessoa');
    }

    public function tablePessoa()
    {

        $Dados = $this->model_pessoa->getAll();
        $dados["data"] = array();
        foreach ($Dados as $lista)
        {
            $btn_editar = "<button type='button' onclick=\"editar(" .$lista->id. ",'{$lista->nome}','{$lista->cpf}','{$lista->cep}','{$lista->numero}','{$lista->logradouro}','{$lista->bairro}','{$lista->estado}','{$lista->municipio}')\" class='btn btn-default'><i class='fa fa-pencil'></i></button>";
            $btn_excluir = "<button type='button' onclick='remover(" . $lista->id . ")' class='btn btn-default'><i class='fa fa-trash'></i></button>";

            $dados['data'][] = array(
                'Nome' => $lista->nome,
                'CPF' => $lista->cpf,
                'Endereço' => $lista->logradouro,
                'Editar' => $btn_editar,
                'Salvar' => $btn_excluir
            );
        }
        echo (json_encode($dados));
    }
    
    public function inserePessoa()
    {  
        $dados["nome"] =  $this->input->post_get('pessoa_nome');
        $dados["cpf"] = preg_replace('/[^0-9]/', '',$this->input->post_get('pessoa_cpf'));
        $dados["cep"] = $this->input->post_get('pessoa_cep');
        $dados["numero"] = $this->input->post_get('pessoa_numero');
        $dados["logradouro"] = $this->input->post_get('pessoa_logradouro');
        $dados["bairro"] = $this->input->post_get('pessoa_bairro');
        $dados["estado"] = $this->input->post_get('pessoa_estado');
        $dados["municipio"] = $this->input->post_get('pessoa_municipio');

        $retorno = $this->model_pessoa->inserePessoa($dados);

        echo (json_encode($retorno));
    }

    public function editaPessoa()
    {  
        $dados["id_pessoa"] =  $this->input->post_get('id_pessoa');
        $dados["nome"] =  $this->input->post_get('pessoa_nome');
        $dados["cpf"] = preg_replace('/[^0-9]/', '',$this->input->post_get('pessoa_cpf'));
        $dados["cep"] = $this->input->post_get('pessoa_cep');
        $dados["numero"] = $this->input->post_get('pessoa_numero');
        $dados["logradouro"] = $this->input->post_get('pessoa_logradouro');
        $dados["bairro"] = $this->input->post_get('pessoa_bairro');
        $dados["estado"] = $this->input->post_get('pessoa_estado');
        $dados["municipio"] = $this->input->post_get('pessoa_municipio');

        $retorno = $this->model_pessoa->editaPessoa($dados);

        echo (json_encode($retorno));
    }

    public function excluirPessoa()
    {  
        $dados["id"] =  $this->input->post_get('id');
        $retorno = $this->model_pessoa->excluirPessoa($dados);
        echo (json_encode($retorno));
    }
}