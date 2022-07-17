<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_pessoa extends CI_Model {

    public function getAll() {
        $SQL = "
        SELECT id
            ,nome
            --,cpf
            ,CONCAT(SUBSTRING(cpf,1,3),'.',
                SUBSTRING(cpf,4,3),'.',
                SUBSTRING(cpf,7,3),'-',
                SUBSTRING(cpf,10,2)) cpf
            ,cep
            ,numero
            ,logradouro
            ,bairro
            ,estado
            ,municipio
        FROM pessoas";
        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function inserePessoa($dados) {

		$this->db->set("nome", $dados['nome']);
        $this->db->set("cpf", $dados['cpf']);
        $this->db->set("cep", $dados['cep']);
        $this->db->set("numero", $dados['numero']);
        $this->db->set("logradouro", $dados['logradouro']);
        $this->db->set("bairro", $dados['bairro']);
        $this->db->set("estado", $dados['estado']);
        $this->db->set("municipio", $dados['municipio']);
        
        $this->db->insert("pessoas");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }        
	}

    public function editaPessoa($dados) {
        $this->db->where("id", $dados["id_pessoa"]);

        $this->db->set("nome", $dados['nome']);
        $this->db->set("cpf", $dados['cpf']);
        $this->db->set("cep", $dados['cep']);
        $this->db->set("numero", $dados['numero']);
        $this->db->set("logradouro", $dados['logradouro']);
        $this->db->set("bairro", $dados['bairro']);
        $this->db->set("estado", $dados['estado']);
        $this->db->set("municipio", $dados['municipio']);

        $this->db->update("pessoas");
        $this->db->trans_complete();
        if ($this->db->trans_status() === true) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }   
    }

    public function excluirPessoa($dados) {
        $this->db->where("id", $dados["id"]);
        $this->db->delete("pessoas");
        return true;
    }

}