<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_conta extends CI_Model {

    public function getAll() {
        $SQL = "
        SELECT
            id_conta
            ,c.id
            ,conta_numero
            ,p.nome
            --,p.cpf
            ,CONCAT(SUBSTRING(p.cpf,1,3),'.',
                SUBSTRING(p.cpf,4,3),'.',
                SUBSTRING(p.cpf,7,3),'-',
                SUBSTRING(p.cpf,10,2)) cpf
            ,(select COUNT(id_movimentacao) from movimentacao m where m.id_conta = c.id_conta) valida_movimentacao
        FROM conta c
        JOIN pessoas p on c.id = p.id";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function verificaContaNumero($dados) {
        $SQL = "
        SELECT DISTINCT
            conta_numero
        FROM conta 
        WHERE conta_numero = ".$dados['conta_numero'];
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function insereConta($dados) {

		$this->db->set("id", $dados['id']);
        $this->db->set("conta_numero", $dados['conta_numero']);
        $this->db->insert("conta");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }        
	}

    public function editaConta($dados) {
        $this->db->where("id_conta", $dados["id_conta"]);
        $this->db->set("id", $dados['id']);
        $this->db->set("conta_numero", $dados['conta_numero']);

        $this->db->update("conta");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }   
    }

    public function excluirConta($dados) {
        $this->db->where("id_conta", $dados["id"]);
        $this->db->delete("conta");
        return true;
    }

}