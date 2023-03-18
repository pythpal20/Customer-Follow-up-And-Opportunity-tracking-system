<?php

    function getStatusBar($idfollo)
    {
        $ci = get_instance();
        $sql = "SELECT * FROM `tb_followup_detail` WHERE followup_id = '$idfollo' AND followup_date = (SELECT MAX(followup_date) FROM tb_followup_detail WHERE followup_id = '$idfollo')";
        $ro  = $ci->db->query($sql)->row_array();

        if ($ro['comment'] == '0') {
            $bar = '20%';
        } else if ($ro['comment'] == '1') {
            $bar = '40%';
        } else if ($ro['comment'] == '2') {
            $bar = '60%';
        } else if ($ro['comment'] == '3') {
            $bar = '80%';
        } else if ($ro['comment'] == '4') {
            $bar = '100%';
        }

        return $bar;
    }

    function getStatus($idfollo)
    {
        $ci = get_instance();
        $sql = "SELECT * FROM `tb_followup_detail` WHERE followup_date = (SELECT MAX(followup_date) FROM tb_followup_detail WHERE followup_id = '$idfollo' )";
        $ro  = $ci->db->query($sql)->row_array();

        if ($ro['comment'] == '0') {
            $bars = '20%';
        } else if ($ro['comment'] == '1') {
            $bars = '40%';
        } else if ($ro['comment'] == '2') {
            $bars = '60%';
        } else if ($ro['comment'] == '3') {
            $bars = '80%';
        } else if ($ro['comment'] == '4') {
            $bars = '100%';
        }

        return $bars;
    }