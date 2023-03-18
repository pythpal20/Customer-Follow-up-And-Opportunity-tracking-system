<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_followup extends CI_Model
{
    public function getCustomer($nama, $role_id)
    {
        if($role_id != '1') {
            $this->db->select('*')
                ->from('tb_followup')
                ->where('add_by', $nama)
                ->order_by('date', 'DESC');
        } else {
            $this->db->select('*')
                ->from('tb_followup')
                ->order_by('date', 'DESC');
        }
        $query = $this->db->get();

        return $query;
    }

    public function getUrutan($format)
    {
        $sql    = "SELECT MAX(kode) AS idArr
        FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(followup_id, 12, 5) AS urutan FROM tb_followup WHERE format_customer = '$format' ) AS tabel_a) AS table_b";
        $query  = $this->db->query($sql);
        return $query;
    }

    public function getDetailCustomer($nama, $role_id)
    {
        if ($role_id != '1') {
            $this->db->select('a.customer_name, b.comment, b.followup_date, b.due_date, a.status, a.is_open, a.followup_id, a.add_by')
                ->from('tb_followup a')
                ->join('tb_followup_detail b', 'a.followup_id = b.followup_id')
                ->where('a.add_by', $nama)
                ->order_by('b.followup_date', 'DESC');
        } else {
            $this->db->select('a.customer_name, b.comment, b.followup_date, b.due_date, a.status, a.is_open, a.followup_id, a.add_by')
                ->from('tb_followup a')
                ->join('tb_followup_detail b', 'a.followup_id = b.followup_id')
                ->order_by('b.followup_date', 'DESC');
        }

        $query = $this->db->get();
        return $query;
    }

    public function getTheMax($idfollo){
        $sql = "SELECT * FROM `tb_followup_detail` WHERE followup_id = '$idfollo' AND followup_date = (SELECT MAX(followup_date) FROM tb_followup_detail WHERE followup_id = '$idfollo' )";
        $ro  = $this->db->query($sql);

        return $ro;
    }
}
