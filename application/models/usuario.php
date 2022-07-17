<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuario extends CI_Model {

    public function validar_login($email, $senha) {
        $SQL = "
            SELECT 
                u.senha,
                u.nome,
                u.email,
                u.id_usuario
            FROM usuario u 
            WHERE email = '$email'
            AND senha = '$senha'";

        $query = $this->db->query($SQL);
        return $query->result();
    }

    public function busca_usuario($dados) {
        $SQL = "
            SELECT
                u.id_usuario,
                u.senha,
                u.nome,
                u.email
            FROM usuario u 
            WHERE u.id_usuario = " . $dados["id_usuario"];
        $query = $this->db->query($SQL);
        return $query->result();
    }
}