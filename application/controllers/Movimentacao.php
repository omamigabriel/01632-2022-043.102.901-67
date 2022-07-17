<?php  

defined('BASEPATH') or exit('No direct script access allowed');

class Movimentacao extends CI_Controller
{

    private $view = array();

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('model_movimentacao');
        $this->load->model('model_conta');
    }

    public function tableMovimentacao()
    {
        $dados["id_conta"] =  $this->input->post_get('id_conta');
        $Dados = $this->model_movimentacao->getAll($dados);
        $dados["data"] = array();
        foreach ($Dados as $lista)
        {
            $valor = $lista->valor;
            if($valor < 0){
                $valor = '<span style="color:red;">'.$lista->valor.'</span>';
            }
            $dados['data'][] = array(
                'Data' => $lista->ft_data_movimentacao,
                'Valor' => $valor,
            );
        }
        echo (json_encode($dados));
    }

    public function verificaSaldo()
    {
        $dados['id_conta'] = $this->input->post_get('id');
        $Dados = $this->model_movimentacao->verificaSaldoConta($dados);
        foreach ($Dados as $lista)
        {
            $data['valor'] = $lista->valor;
        }

        echo (json_encode($data));
    }

    private function verificaSaldoConta($dados)
    {
        $saldo_conta = null;
        $movimentacao_valor = $dados['valor'];
        $Dados = $this->model_movimentacao->verificaSaldoConta($dados);
        foreach ($Dados as $lista)
        {
            $saldo_conta = $lista->valor;
        }

        if ($saldo_conta > $movimentacao_valor)
        {
            $permissao = true;
        } else
        {
            $permissao = false;
        }

        return $permissao;
    }
    
    public function insereMovimentacao()
    {  
        $movimentacao_numero = $this->input->post_get('movimentacao_numero');
        $movimentacao_depositar_retirar = $this->input->post_get('movimentacao_depositar_retirar');
        $movimentacao_valor = $this->input->post_get('movimentacao_valor');

        $dados["id_conta"] = $movimentacao_numero;
        $dados["movimentacao"] = $movimentacao_depositar_retirar;
        $dados["valor"] = $movimentacao_valor;

        if($movimentacao_depositar_retirar == 'depositar')
        {
            $permissao = true;
        }else
        {
            $permissao = $this->verificaSaldoConta($dados);
        }

        if ($permissao)
        {
            $dados["id_conta"] = $movimentacao_numero;
            $dados["movimentacao"] = $movimentacao_depositar_retirar;
            if($movimentacao_depositar_retirar == 'depositar'){
                $dados["valor"] = $movimentacao_valor;
            }else{
                $dados["valor"] = '-'.$movimentacao_valor;
            }
            $dados["data_movimentacao"] = date("ymd H:i:s");
            $this->model_movimentacao->insereMovimentacao($dados);

            $mensagem = 'Cadastrado com sucesso!';
            $color = 'success';
        } else
        {
            $mensagem = 'Saldo insuficiente!';
            $color = 'warning';
        }
        echo (json_encode(array(
            "mensagem" => $mensagem,
            "color" => $color
        )));
    }

    public function listaPessoaConta()
    {
        $Dados = $this->model_movimentacao->getAllDistinctContas();
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


    public function listaContaNumero()
    {
        $dados["id"] = $this->input->post_get('id');

        $Dados = $this->model_movimentacao->listaContaNumero($dados);
        $n = 0;
        $dados["id_conta"] = array();
        foreach ($Dados as $lista)
        {
            $dados ['id_conta'] [$n] = $lista->id_conta;
            $dados ['conta_numero'] [$n] = $lista->conta_numero;
            $dados ['valor'] [$n] = $lista->valor;

            $n++;
        }
        echo (json_encode($dados));
    }
}