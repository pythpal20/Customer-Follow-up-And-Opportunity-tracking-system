<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('countPo')) {
    function countPo($pengguna, $bulan)
    {
        $ci = get_instance();
        
        $query = "SELECT COUNT(a.id) AS jumlahPO
        FROM tb_followup_detail a 
        JOIN tb_followup b ON a.followup_id = b.followup_id
        WHERE a.comment = '4'
        AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%m') = ?
        AND b.add_by = ?";
        
        $query = $ci->db->query($query, array($bulan, $pengguna))->row_array();
        
        $counting = $query["jumlahPO"];
        return $counting;
    }
}
if(!function_exists('sumPo')) {
    function sumPo($pengguna, $bulan)
    {
        $ci = get_instance();
        
        $query = "SELECT SUM(a.transaction_value) AS jumlahPO
        FROM tb_followup_detail a 
        JOIN tb_followup b ON a.followup_id = b.followup_id
        WHERE a.comment = '4'
        AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%m') = ? AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y') = DATE_FORMAT(CURRENT_DATE(), '%Y')
        AND b.add_by = ?";
        
        $query = $ci->db->query($query, array($bulan, $pengguna))->row_array();
        
        $counting = $query["jumlahPO"];
        return $counting;
    }
}