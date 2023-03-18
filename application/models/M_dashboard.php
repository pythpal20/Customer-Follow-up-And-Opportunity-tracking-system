<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function hitungToday($tawal, $takhir)
    {
        $sql = "SELECT COUNT(kode) AS jumlah, nama_orang FROM
    (SELECT a.followup_id AS kode, b.add_by AS nama_orang, b.customer_name AS customer
    FROM tb_followup_detail a 
    JOIN tb_followup b ON a.followup_id = b.followup_id
    WHERE a.followup_date BETWEEN '$tawal' AND '$takhir'
    GROUP BY b.customer_name) AS Tb_A
    GROUP BY nama_orang";

        $query  = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function hitungOpportunity($thisMonth, $thisYear)
    {
        $sql = "SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(progress, '0', 'Kontak'), '1', 'Followup'), '2', 'Penawaran'), '3', 'FU Penawaran'), '4', 'Jadi PO') AS prog, COUNT(progress) AS cprog FROM
        (SELECT b.add_by AS users, a.followup_id, MAX(`a`.`comment`) AS progress 
        FROM tb_followup_detail a 
        JOIN tb_followup b ON a.followup_id = b.followup_id
        WHERE MONTH(FROM_UNIXTIME(a.followup_date)) = '$thisMonth' AND YEAR(FROM_UNIXTIME(a.followup_date)) = '$thisYear'
        GROUP BY followup_id) AS table_a
        GROUP BY progress";

        $query  = $this->db->query($sql);
        return $query;
    }

    public function myOpportunity($thisMonth, $thisYear, $users)
    {
        $sql = "SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(progress, '0', 'Kontak'), '1', 'Followup'), '2', 'Penawaran'), '3', 'FU Penawaran'), '4', 'Jadi PO') AS prog, COUNT(progress) AS cprog FROM
        (SELECT b.add_by AS users, a.followup_id, MAX(`a`.`comment`) AS progress 
        FROM tb_followup_detail a 
        JOIN tb_followup b ON a.followup_id = b.followup_id
        WHERE MONTH(FROM_UNIXTIME(a.followup_date)) = '$thisMonth' AND YEAR(FROM_UNIXTIME(a.followup_date)) = '$thisYear'
        GROUP BY followup_id) AS table_a
        WHERE users ='$users'
        GROUP BY progress";

        $query  = $this->db->query($sql);
        return $query;
    }
    
    public function masterOpp($tawal, $takhir, $users)
    {
        $sql = "SELECT REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(progress, '0', 'Kontak'), '1', 'Followup'), '2', 'Penawaran'), '3', 'FU Penawaran'), '4', 'Jadi PO') AS prog, COUNT(progress) AS cprog FROM
        (SELECT b.add_by AS users, a.followup_id, MAX(`a`.`comment`) AS progress 
        FROM tb_followup_detail a 
        JOIN tb_followup b ON a.followup_id = b.followup_id
        WHERE a.followup_date BETWEEN '$tawal' AND '$takhir'
        GROUP BY followup_id) AS table_a
        WHERE users ='$users'
        GROUP BY progress";

        $query  = $this->db->query($sql);
        return $query;
    }
    
    public function hitungClosePO($thisMonth, $thisYear)
    {
        $sql = "SELECT * FROM tb_followup a
        JOIN tb_followup_detail b ON a.followup_id = b.followup_id
        WHERE a.is_open = '0' AND (MONTH(FROM_UNIXTIME(a.date)) = '03' AND YEAR(FROM_UNIXTIME(a.date))) AND b.`comment` = '4'
        GROUP BY a.followup_id";
        $query  = $this->db->query($sql);
        return $query;
    }
    
    public function hitungClosenonPO($thisMonth, $thisYear)
    {
        $sql = "SELECT DISTINCT(b.followup_id)
        FROM (SELECT followup_id FROM tb_followup_detail WHERE `comment` != '4') AS tb_a
        LEFT JOIN (SELECT followup_id FROM tb_followup_detail WHERE `comment` = '4') AS tb_b ON tb_a.followup_id = tb_b.followup_id
        JOIN tb_followup b ON tb_a.followup_id = b.followup_id
        WHERE (tb_b.followup_id IS NULL AND b.is_open = '0') AND MONTH(FROM_UNIXTIME(b.date)) = '$thisMonth' AND YEAR(FROM_UNIXTIME(b.date)) = '$thisYear'";
        $query  = $this->db->query($sql);
        return $query;
    }
    
    public function hitungOpen($thisYear, $thisMonth)
    {
        $this->db->select('*')
            ->from('tb_followup')
            ->where('is_open', '1')
            ->where('MONTH(FROM_UNIXTIME(date)) = ', $thisMonth)
            ->where('YEAR(FROM_UNIXTIME(date)) = ', $thisYear);
        $query  = $this->db->get();
        return $query;
    }
    
    
}
