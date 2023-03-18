<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function getSumfu()
    {
        $this_year = date('Y');
        $sql = "SELECT 
        b.add_by,
        COUNT(IF(a.comment = '0', a.comment, NULL)) AS kontak,  
        COUNT(IF(a.comment = '1', a.comment, NULL)) AS followup,
        COUNT(IF(a.comment = '2', a.comment, NULL)) AS penawaran,
        COUNT(IF(a.comment = '3', a.comment, NULL)) AS followup_penawaran,
        COUNT(IF(a.comment = '4', a.comment, NULL)) AS orders
        FROM tb_followup_detail a 
        JOIN tb_followup b ON a.followup_id = b.followup_id
        WHERE YEAR(FROM_UNIXTIME(a.followup_date)) = '$this_year'
        GROUP BY b.add_by";

        $query = $this->db->query($sql);

        return $query;
    }

    public function getJumlahCustomer($id, $tawal, $takhir)
    {
        $today = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('tb_followup');
        $this->db->where('add_by', $id);
        $this->db->where('date_format(FROM_UNIXTIME(`date`), "%Y-%m-%d") = "' . $today . '"');

        $query = $this->db->get();
        return $query;
    }

    public function dataKontak($id, $tawal, $takhir)
    {
        $this->db->select('*');
        $this->db->from('tb_followup_detail');
        $this->db->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id');
        $this->db->where('tb_followup.add_by', $id);
        $this->db->where('tb_followup_detail.comment', '0');
        $this->db->where('tb_followup_detail.followup_date BETWEEN "' . $tawal . '" AND "' . $takhir . '"');
        $this->db->group_by('tb_followup_detail.followup_id');

        $query = $this->db->get();
        return $query;
    }

    public function dataFollowup($id, $tawal, $takhir)
    {
        $this->db->select('*');
        $this->db->from('tb_followup_detail');
        $this->db->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id');
        $this->db->where('tb_followup.add_by', $id);
        $this->db->where('tb_followup_detail.comment', '1');
        $this->db->where('tb_followup_detail.followup_date BETWEEN "' . $tawal . '" AND "' . $takhir . '"');
        $this->db->group_by('tb_followup_detail.followup_id');

        $query = $this->db->get();
        return $query;
    }

    public function dataPenawaran($id, $tawal, $takhir)
    {
        $this->db->select('*');
        $this->db->from('tb_followup_detail');
        $this->db->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id');
        $this->db->where('tb_followup.add_by', $id);
        $this->db->where('tb_followup_detail.comment', '2');
        $this->db->where('tb_followup_detail.followup_date BETWEEN "' . $tawal . '" AND "' . $takhir . '"');
        $this->db->group_by('tb_followup_detail.followup_id');

        $query = $this->db->get();
        return $query;
    }

    public function datafuPenawaran($id, $tawal, $takhir)
    {
        $this->db->select('*');
        $this->db->from('tb_followup_detail');
        $this->db->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id');
        $this->db->where('tb_followup.add_by', $id);
        $this->db->where('tb_followup_detail.comment', '3');
        $this->db->where('tb_followup_detail.followup_date BETWEEN "' . $tawal . '" AND "' . $takhir . '"');
        $this->db->group_by('tb_followup_detail.followup_id');

        $query = $this->db->get();
        return $query;
    }

    public function dataOrder($id, $tawal, $takhir)
    {
        $this->db->select('*');
        $this->db->from('tb_followup_detail');
        $this->db->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id');
        $this->db->where('tb_followup.add_by', $id);
        $this->db->where('tb_followup_detail.comment', '4');
        $this->db->where('tb_followup_detail.followup_date BETWEEN "' . $tawal . '" AND "' . $takhir . '"');
        $this->db->group_by('tb_followup_detail.followup_id');

        $query = $this->db->get();
        return $query;
    }

    public function dataKategori($id, $tawal, $takhir)
    {
        $this->db->select('tb_category.nama, COUNT(tb_followup.followup_id) AS fu_id')
            ->from('tb_followup')
            ->join('tb_category', 'tb_followup.id_category = tb_category.kode')
            ->where('tb_followup.add_by', $id)
            ->where('tb_followup.date BETWEEN "' . $tawal . '" AND "' . $takhir . '"')
            ->group_by('tb_followup.id_category');
        $query = $this->db->get();

        return $query;
    }
}
