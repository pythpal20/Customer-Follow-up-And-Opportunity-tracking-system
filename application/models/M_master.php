<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function getSumfu($waktu)
    {
        $this_year = date('Y');
        $this_month = date('m');
        $last_month = date('m', strtotime("-1 month"));
        if($waktu == 'thismonth') {
            $sql = "SELECT b.add_by,
                COUNT(IF(max_com = '0', max_com, NULL)) AS kontak,
                COUNT(IF(max_com = '1', max_com, NULL)) AS followup,
                COUNT(IF(max_com = '2', max_com, NULL)) AS penawaran,
                COUNT(IF(max_com = '3', max_com, NULL)) AS followup_penawaran,
                COUNT(IF(max_com = '4', max_com, NULL)) AS orders
            FROM (SELECT followup_id, MAX(`comment`) AS max_com, followup_date FROM tb_followup_detail WHERE MONTH(FROM_UNIXTIME(followup_date)) = '$this_month' AND YEAR(FROM_UNIXTIME(followup_date)) = '$this_year' GROUP BY followup_id) AS tb_a
            JOIN tb_followup b ON tb_a.followup_id = b.followup_id
            GROUP BY b.add_by";
        } else if($waktu == 'lastmonth') {
            $sql = "SELECT b.add_by,
                COUNT(IF(max_com = '0', max_com, NULL)) AS kontak,
                COUNT(IF(max_com = '1', max_com, NULL)) AS followup,
                COUNT(IF(max_com = '2', max_com, NULL)) AS penawaran,
                COUNT(IF(max_com = '3', max_com, NULL)) AS followup_penawaran,
                COUNT(IF(max_com = '4', max_com, NULL)) AS orders
            FROM (SELECT followup_id, MAX(`comment`) AS max_com, followup_date FROM tb_followup_detail WHERE MONTH(FROM_UNIXTIME(followup_date)) = '$last_month' AND YEAR(FROM_UNIXTIME(followup_date)) = '$this_year' GROUP BY followup_id) AS tb_a
            JOIN tb_followup b ON tb_a.followup_id = b.followup_id
            GROUP BY b.add_by";
        } else if($waktu == 'thisyear') {
            $sql = "SELECT b.add_by,
                COUNT(IF(max_com = '0', max_com, NULL)) AS kontak,
                COUNT(IF(max_com = '1', max_com, NULL)) AS followup,
                COUNT(IF(max_com = '2', max_com, NULL)) AS penawaran,
                COUNT(IF(max_com = '3', max_com, NULL)) AS followup_penawaran,
                COUNT(IF(max_com = '4', max_com, NULL)) AS orders
            FROM (SELECT followup_id, MAX(`comment`) AS max_com, followup_date FROM tb_followup_detail WHERE (MONTH(FROM_UNIXTIME(followup_date)) BETWEEN '01' AND '12') AND YEAR(FROM_UNIXTIME(followup_date)) = '$this_year' GROUP BY followup_id) AS tb_a
            JOIN tb_followup b ON tb_a.followup_id = b.followup_id
            GROUP BY b.add_by";
        }
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
    
    public function getToday($tgl)
    {
        $sql = "SELECT b.add_by,
        COUNT(IF(max_com = '0', max_com, NULL)) AS kontak,
        COUNT(IF(max_com = '1', max_com, NULL)) AS followup,
        COUNT(IF(max_com = '2', max_com, NULL)) AS penawaran,
        COUNT(IF(max_com = '3', max_com, NULL)) AS followup_penawaran,
        COUNT(IF(max_com = '4', max_com, NULL)) AS orders
        FROM (SELECT followup_id, MAX(`comment`) AS max_com, followup_date FROM tb_followup_detail WHERE DATE_FORMAT(FROM_UNIXTIME(followup_date), '%Y-%m-%d') = '" . $tgl . "' GROUP BY followup_id) AS tb_a
        JOIN tb_followup b ON tb_a.followup_id = b.followup_id
        GROUP BY b.add_by
        ORDER BY orders DESC";

        $query = $this->db->query($sql);

        return $query;
    }
    
    public function get_closewith()
    {
        $sql = "SELECT close_with, COUNT(followup_id) as jumlah
                FROM tb_followup
                WHERE is_open = '0' AND close_with != '0'
                AND MONTH(FROM_UNIXTIME(date)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(date)) = YEAR(CURRENT_DATE())
                GROUP BY close_with";
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    function nominalPo() //this month and year
    {
        $sql = "SELECT SUM(nominalpo) AS nompo, format_customer 
        FROM tb_followup 
        WHERE close_with = '0'
        AND MONTH(FROM_UNIXTIME(date)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(date)) = YEAR(CURRENT_DATE())
        GROUP BY format_customer";
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    function nominalUser($user_nama)
    {
        $sql = "SELECT SUM(nominalpo) AS nompo, add_by 
        FROM tb_followup 
        WHERE close_with = '0' AND add_by = '" . $user_nama . "'
        AND MONTH(FROM_UNIXTIME(date)) = MONTH(CURRENT_DATE()) AND YEAR(FROM_UNIXTIME(date)) = YEAR(CURRENT_DATE())";
        $query = $this->db->query($sql);
        
        return $query;
    }
    
    public function listPenawaranAktif($tawal, $takhir, $pengguna) 
    {
        if($pengguna == 'all') {
        $this->db->select('FROM_UNIXTIME(tb_followup_detail.followup_date) AS tglPenawaran, tb_followup.customer_name, tb_followup_detail.transaction_id, tb_followup_detail.transaction_value, tb_followup_detail.notes, tb_followup.add_by, tb_followup_detail.followup_value, tb_followup_detail.followup_id')
            ->from('tb_followup_detail')
            ->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id')
            ->where('tb_followup.is_open', '1')
            ->where('tb_followup_detail.comment', '2')
            ->where('FROM_UNIXTIME(tb_followup_detail.followup_date) >=', $tawal)
            ->where('FROM_UNIXTIME(tb_followup_detail.followup_date) <=', $takhir)
            ->order_by('tb_followup.add_by', 'ASC')
            ->order_by('tb_followup_detail.followup_date', 'DESC');
        } else {
            $this->db->select('FROM_UNIXTIME(tb_followup_detail.followup_date) AS tglPenawaran, tb_followup.customer_name, tb_followup_detail.transaction_id, tb_followup_detail.transaction_value, tb_followup_detail.notes, tb_followup.add_by, tb_followup_detail.followup_value, tb_followup_detail.followup_id')
            ->from('tb_followup_detail')
            ->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id')
            ->where('tb_followup.is_open', '1')
            ->where('tb_followup_detail.comment', '2')
            ->where('FROM_UNIXTIME(tb_followup_detail.followup_date) >=', $tawal)
            ->where('FROM_UNIXTIME(tb_followup_detail.followup_date) <=', $takhir)
            ->where('tb_followup.add_by', $pengguna)
            ->order_by('tb_followup.add_by', 'ASC')
            ->order_by('tb_followup_detail.followup_date', 'DESC');
        }
    
        $query = $this->db->get();
    
        return $query;
    }
    
    public function listPenggunaaktif()
    {
        $this->db->select('DISTINCT(tb_followup.add_by)')
            ->from('tb_followup')
            ->join('tb_user', 'tb_followup.add_by = tb_user.user_nama')
            ->where('tb_user.is_active', '1')
            ->order_by('tb_user.user_nama', 'ASC');
        
        $query = $this->db->get();
        return $query;
    }
    
    public function openOpportunity()
    {
        $year   = date('Y');
        $month  = date('m');
        $this->db->select('tb_followup_detail.followup_id, tb_followup.customer_name, MAX(tb_followup_detail.comment) AS progress, tb_followup.add_by, user_role.role')
            ->from('tb_followup_detail')
            ->join('tb_followup', 'tb_followup_detail.followup_id = tb_followup.followup_id')
            ->join('tb_user', 'tb_followup.add_by = tb_user.user_nama')
            ->join('user_role', 'tb_user.role_id = user_role.role_id')
            ->where('tb_followup.is_open', '1')
            ->where('YEAR(FROM_UNIXTIME(tb_followup_detail.followup_date))', $year)
            ->where('MONTH(FROM_UNIXTIME(tb_followup_detail.followup_id))', $month)
            ->group_by('tb_followup_detail.followup_id');

        $query = $this->db->get();
        return $query;          
    }

}
