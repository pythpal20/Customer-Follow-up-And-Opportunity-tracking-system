<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    public function allUser()
    {
        $this->db->select('tb_user.*, user_role.role');
        $this->db->from('tb_user');
        $this->db->join('user_role', 'tb_user.role_id = user_role.role_id');
        $this->db->where('tb_user.is_active', '1');
        $this->db->order_by('user_role.role_id', 'ASC');

        $query = $this->db->get();
        return $query;
    }

    public function urutanUser()
    {
        $sql = "SELECT MAX(kode) AS idUser
            FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(user_id, 4) AS urutan FROM tb_user) AS tabel_a) AS table_b";
        $query  = $this->db->query($sql);
        return $query;
    }

    public function getUserdetail($id)
    {
        $this->db->select('tb_user.*, user_role.role');
        $this->db->from('tb_user');
        $this->db->join('user_role', 'tb_user.role_id = user_role.role_id');
        $this->db->where('tb_user.user_id', $id);
        $query = $this->db->get();
        return $query;
    }
}
