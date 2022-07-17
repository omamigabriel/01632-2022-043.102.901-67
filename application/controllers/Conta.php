<?php  

defined('BASEPATH') or exit('No direct script access allowed');

class Conta extends CI_Controller
{

    private $view = array();

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('model_conta');
        $this->load->model('model_pessoa');
    }

    public function tableConta()
    {

        $Dados = $this->model_conta->getAll();
        $dados["data"] = array();
        foreach ($Dados as $lista)
        {
            $btn_excluir = '';
            $btn_editar = "<button type='button' onclick='editar_conta(" .$lista->id_conta. "," .$lista->id. "," .$lista->conta_numero. ")' class='btn btn-default'><i class='fa fa-pencil'></i></button>";
            if($lista->valida_movimentacao == 0){
                $btn_excluir = "<button type='button' onclick='remover_conta(" . $lista->id_conta . ")' class='btn btn-default'><i class='fa fa-trash'></i></button>";
            }
            $dados['data'][] = array(
                'Nome' => $lista->nome,
                'CPF' => $lista->cpf,
                'NumeroConta' => $lista->conta_numero,
                'Editar' => $btn_editar,
                'Salvar' => $btn_excluir
            );
        }
        echo (json_encode($dados));
    }

    private function validaConta($dados)
    {
        $conta_numero = null;
        $Dados = $this->model_conta->verificaContaNumero($dados);
        foreach ($Dados as $lista)
        {
            $conta_numero = $lista->conta_numero;
        }

        if ($conta_numero == null)
        {
            $permissao = true;
        } else
        {
            $permissao = false;
        }

        return $permissao;
    }
    
    public function insereConta()
    {  
        $conta_numero = $this->input->post_get('conta_numero');
        $dados["conta_numero"] = $conta_numero;
        $permissao = $this->validaConta($dados);

        if ($permissao)
        {
            $dados["id"] =  $this->input->post_get('conta_pessoa');
            $dados["conta_numero"] = $conta_numero;
            $this->model_conta->insereConta($dados);

            $mensagem = 'Cadastrado com sucesso!';
            $color = 'success';
        } else
        {
            $mensagem = 'Número de conta existente!';
            $color = 'warning';
        }
        echo (json_encode(array(
            "mensagem" => $mensagem,
            "color" => $color
        )));
    }

    public function editaConta()
    {  

        $conta_numero = $this->input->post_get('conta_numero');
        $dados["conta_numero"] = $conta_numero;
        $permissao = $this->validaConta($dados);

        if ($permissao)
        {
            $dados["id_conta"] =  $this->input->post_get('id_conta');
            $dados["id"] =  $this->input->post_get('conta_pessoa');
            $dados["conta_numero"] = $conta_numero;
    
            $retorno = $this->model_conta->editaConta($dados);

            $mensagem = 'Cadastrado com sucesso!';
            $color = 'success';
        } else
        {
            $mensagem = 'Número de conta existente!';
            $color = 'warning';
        }
        echo (json_encode(array(
            "mensagem" => $mensagem,
            "color" => $color
        )));
    }

    public function excluirConta()
    {  
        $dados["id"] =  $this->input->post_get('id');
        $retorno = $this->model_conta->excluirConta($dados);
        echo (json_encode($retorno));
    }

    public function listaPessoa()
    {
        $Dados = $this->model_pessoa->getAll();
        $n = 0;
        $dados["id"] = array();
        foreach ($Dados as $lista)
        {
            $dados ['id'] [$n] = $lista->id;
            $dados ['nome'] [$n] = $lista->nome;
            $dados ['cpf'] [$n] = $lista->cpf;

            $n++;
        }
        echo (json_encode($dados));
    }
}