<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("m_dashboard");
    }
    
    public function index()
    {
        $today = date('Y-m-d');
        $tambahsatuhari = date('Y-m-d', strtotime("+1 day", strtotime($today)));

        $awal   = new DateTimeImmutable($today);
        $akhir  = new DateTimeImmutable($tambahsatuhari);
        $tawal = $awal->format('U');
        $takhir = $akhir->format('U');
        $thisMonth = date('m');
        $thisYear = date('Y');
        $users = $this->session->userdata('nama_lengkap');

        // sendhitungToday
        $data['toDay'] = $this->m_dashboard->hitungToday($tawal, $takhir);
        // onMonth => semua user
        $data['onMonth'] = $this->m_dashboard->hitungOpportunity($thisMonth, $thisYear);
        // onmonth per user
        $data['onMonthuser'] = $this->m_dashboard->myOpportunity($thisMonth, $thisYear, $users);
        
        $hitungClosepo = $this->m_dashboard->hitungClosePO($thisMonth, $thisYear);
        $data['ClosePO'] = count($hitungClosepo->result_array());

        $hitungclosenonpo = $this->m_dashboard->hitungClosenonPO($thisMonth, $thisYear);
        $data['ClosenonPO'] = count($hitungclosenonpo->result_array());

        $hitungOpen = $this->m_dashboard->hitungOpen($thisYear, $thisMonth);
        $data['opens'] = count($hitungOpen->result_array());
        
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}
