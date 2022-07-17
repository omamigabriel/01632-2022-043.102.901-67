<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_movimentacao extends CI_Model {

    public function getAll($dados) {
        $SQL = "
        SELECT 
            valor
            ,CONCAT(CONVERT(CHAR(10), data_movimentacao , 103),' ', CONVERT(CHAR(8), data_movimentacao , 114)) as ft_data_movimentacao
        FROM movimentacao
        WHERE id_conta = ".$dados['id_conta']."
        ORDER BY data_movimentacao DESC";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function getAllDistinctContas() {
        $SQL = "
        SELECT DISTINCT
            c.id
            ,p.nome
            ,CONCAT(SUBSTRING(p.cpf,1,3),'.',
                SUBSTRING(p.cpf,4,3),'.',
                SUBSTRING(p.cpf,7,3),'-',
                SUBSTRING(p.cpf,10,2)) cpf
        FROM conta c
        JOIN pessoas p on c.id = p.id";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function listaContaNumero($dados) {
        $SQL = "
        SELECT c.id_conta
            ,c.id
            ,c.conta_numero
            ,SUM(IIF(m.valor is null, 0, m.valor)) valor
        FROM conta c 
        LEFT JOIN movimentacao m on c.id_conta = m.id_conta
        WHERE c.id = ".$dados['id']."
        GROUP BY c.id_conta,c.id,c.conta_numero";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function verificaSaldoConta($dados) {
        $SQL = "
        SELECT SUM(valor) valor
        FROM movimentacao
        WHERE id_conta = ".$dados['id_conta'];
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function insereMovimentacao($dados) {

		$this->db->set("id_conta", $dados['id_conta']);
        $this->db->set("valor", $dados['valor']);
        $this->db->set("movimentacao", $dados['movimentacao']);
        $this->db->set("data_movimentacao", $dados['data_movimentacao']);
        
        $this->db->insert("movimentacao");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }        
	}
}