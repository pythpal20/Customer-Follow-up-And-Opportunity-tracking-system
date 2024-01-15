<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("m_dashboard");
        // $this->output->enable_profiler(TRUE);
        
        require APPPATH . 'libraries/phpmailer/src/Exception.php';
        require APPPATH . 'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH . 'libraries/phpmailer/src/SMTP.php';
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
        
        $data['perBagian'] = $this->m_dashboard->hitungBagian($thisYear, $thisMonth);
        $data['perBagianKontak'] = $this->m_dashboard->hitungBagianKontak($thisYear, $thisMonth);
        $data['perBagianFu'] = $this->m_dashboard->hitungBagianFu($thisYear, $thisMonth);
        $data['perBagianPenawaran'] = $this->m_dashboard->hitungBagianPenawaran($thisYear, $thisMonth);
        $data['perBagianPenawaran'] = $this->m_dashboard->hitungBagianPenawaran($thisYear, $thisMonth);
        $data['followupPn'] = $this->m_dashboard->hitungBagianFuPn($thisYear, $thisMonth);
        
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
        
        $tcustomer = $this->m_dashboard->totalCustomer();
        $data['totalCustomer'] = count($tcustomer->result_array());
        
        $data['dby'] = $this->m_dashboard->dailySummary($users, $today);
        
        $data['notip'] = $this->m_dashboard->getData($users);

        $config['base_url'] = base_url('dashboard/index');
        $config['total_rows'] = count($data['notip']);
        $config['per_page'] = 8;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['attributes'] = array('class' => 'page-link');
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $start = $this->uri->segment(3) ? $this->uri->segment(3) : 0;

        $data['notip'] = array_slice($data['notip'], $start, $config['per_page']);
        $data['links'] = $this->pagination->create_links();
        
        $data['sales'] = $this->m_dashboard->getSales();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function chartBoard()
    {
        $data['title'] = "Dashboard Chart";
        $this->load->view('templates/grafik_header', $data);
        $this->load->view('dashboard/chartBoard', $data);
        $this->load->view('templates/grafik_footer');
    }

    public function getdataGrafik()
    {
        $today = date('Y-m-d');
        $tambahsatuhari = date('Y-m-d', strtotime("+1 day", strtotime($today)));
        $awal   = new DateTimeImmutable($today);
        $akhir  = new DateTimeImmutable($tambahsatuhari);
        $tawal = $awal->format('U');
        $takhir = $akhir->format('U');
        $thisMonth = date('m');
        $thisYear = date('Y');

        $bulan = $this->m_dashboard->hitungOpportunity($thisMonth, $thisYear);

        $data = [];
        foreach ($bulan->result() as $b) {
            $data[] = array(
                'label' => $b->prog,
                'value' => $b->cprog
            );
        }

        echo json_encode($data);
    }

    public function perBagians()
    {
        $bagian = $this->m_dashboard->perBagian();
        $data = [];
        foreach ($bagian->result() as $b) {
            $data[] = array(
                'label' => $b->format_customer,
                'value' => $b->totals
            );
        }

        echo json_encode($data);
    }
    
    public function grafikPerSales()
    {
        $sales = $this->m_dashboard->getSales();

        $data = array();
        foreach($sales->result() AS $s){
            $nama_user  = $s->add_by;

            $followup   = $this->m_dashboard->getFollowupByUser($nama_user);

            $total_order    = 0;
            $total_nonorder = 0;
            $total_open     = 0;

            foreach($followup->result() AS $f){
                $total_order    = $f->jumlah_order;
                $total_nonorder = $f->jumlah_nonOrder;
                $total_open     = $f->opens;
            }

            $total_followup     = $total_order + $total_nonorder + $total_open;
            $persen_order       = ($total_order/ $total_followup) * 100;
            $persen_nonorder    = ($total_nonorder/ $total_followup) * 100;
            $persen_open        = ($total_open/ $total_followup) * 100;

            $data[] = array(
                'nama_user'     => explode(" ", $nama_user)[0],
                'persen_order'  => $persen_order,
                'persen_nonorder'   => $persen_nonorder,
                'persen_open'   => $persen_open
            );
        }

        echo json_encode($data);
    }
    
    public function perBagianSevenDays(){
        $bagian = $this->m_dashboard->getBagian();
    
        $datasets = array();
        foreach ($bagian->result() AS $b){
            $nama_bagian = $b->format_customer;
    
            $jumlah_followup = $this->m_dashboard->getdataBagians($nama_bagian);
    
            $data = array();
            $labels = array();
            foreach($jumlah_followup->result() AS $jf){
                $data[] = $jf->jumlahFollowup;
                $labels[] = $jf->tgl;
            }

            $borderColor = [
                'rgb(255, 165, 0)',
                'rgb(189, 183, 107)',
                'rgb(102, 51, 153)',
                'rgb(0, 255, 255)',
                'rgb(70, 130, 180)',
                'rgb(25, 25, 112)'
            ];
    
            $dataset = array(
                'label' => $nama_bagian,
                'data' => $data,
                'fill' => false,
                'borderColor' => $borderColor,
                'backgroundColor'=>$borderColor,
                'tension' => 0.1
            );
    
            $datasets[] = $dataset;
        }
    
        // $labels = array();
        // for ($i = 6; $i >= 0; $i--) {
        //     $day = date('Y-m-d', strtotime("-$i days"));
        //     if (date('w', strtotime($day)) !== '0') {
        //         $labels[] = $day;
        //     }
        // }
    
        $chart_data = array(
            'labels' => $labels,
            'datasets' => $datasets,
        );
    
        echo json_encode($chart_data);
    }  
    
    public function perOrang7Days(){
        $bagian = $this->m_dashboard->getBagian();
    
        $datasets = array();
        $colors = array(
            'rgb(255, 165, 0)',
            'rgb(189, 183, 107)',
            'rgb(102, 51, 153)',
            'rgb(0, 255, 255)',
            'rgb(70, 130, 180)',
            'rgb(25, 25, 112)',
            'rgb(255, 0, 0)',
            'rgb(0, 128, 0)',
            'rgb(0, 0, 255)',
            'rgb(128, 0, 128)',
            'rgb(128, 128, 0)',
            'rgb(0, 128, 128)'
        );
        $color_index = 0;
        foreach ($bagian->result() AS $b){
            $nama_bagian = $b->format_customer;
    
            $jumlah_followup = $this->m_dashboard->get7daysPo($nama_bagian);
    
            $data = array();
            $labels = array();
            foreach($jumlah_followup->result() AS $jf){
                $data[] = $jf->jumlahFollowup;
                $labels[] = $jf->tgl;
            }
    
            $dataset = array(
                'label' => $nama_bagian,
                'data' => $data,
                'backgroundColor'=> $colors[$color_index],
                'borderWidth'=> 1
            );
    
            $datasets[] = $dataset;
            $color_index = ($color_index + 1) % count($colors);
        }
    
        $chart_data = array(
            'labels' => $labels,
            'datasets' => $datasets,
        );
    
        echo json_encode($chart_data);
    } 
    
    public function chartsRadar()
    {
        $sales = $this->m_dashboard->getSales();

        $datasets = array();
        $colors = array(
            'rgb(255, 165, 0)',
            'rgb(189, 183, 107)',
            'rgb(102, 51, 153)',
            'rgb(0, 255, 255)',
            'rgb(70, 130, 180)',
            'rgb(25, 25, 112)',
            'rgb(255, 0, 0)',
            'rgb(0, 128, 0)',
            'rgb(0, 0, 255)',
            'rgb(128, 0, 128)',
            'rgb(25, 25, 112)',
            'rgb(0, 128, 128)',
            'rgb(255, 105, 180)',
            'rgb(255, 160, 122)'
        );
        $color_index = 0;

        foreach ($sales->result() as $s) {
            $nama_user  = $s->add_by;

            $jumlah_followup = $this->m_dashboard->perOrangPertanggal($nama_user);

            $data = array();
            $labels = array();
            foreach ($jumlah_followup->result() as $jf) {
                $data[] = $jf->kontak;
                $labels[] = $jf->tanggal;
            }

            $dataset = array(
                'label'             => $nama_user,
                'data'              => $data,
                'backgroundColor'   => $colors[$color_index],
                'borderWidth'       => 1
            );

            $datasets[] = $dataset;
            $color_index = ($color_index + 1) % count($colors);
        }

        $chart_data = array(
            'labels' => $labels,
            'datasets' => $datasets,
        );
        echo json_encode($chart_data);
    }
    
    public function followup3Days()
    {
        $sales = $this->m_dashboard->getSales();

        $datasets = array();
        $colors = array(
            'rgb(255, 165, 0)',
            'rgb(189, 183, 107)',
            'rgb(102, 51, 153)',
            'rgb(0, 255, 255)',
            'rgb(70, 130, 180)',
            'rgb(25, 25, 112)',
            'rgb(255, 0, 0)',
            'rgb(0, 128, 0)',
            'rgb(0, 0, 255)',
            'rgb(128, 0, 128)',
            'rgb(128, 128, 0)',
            'rgb(0, 128, 128)',
            'rgb(255, 105, 180)',
            'rgb(255, 160, 122)'
        );
        $color_index = 0;

        foreach ($sales->result() as $s) {
            $nama_user  = $s->add_by;

            $jumlah_followup = $this->m_dashboard->perOrangPertanggal($nama_user);

            $data = array();
            $labels = array();
            foreach ($jumlah_followup->result() as $jf) {
                $data[] = $jf->followup;
                $labels[] = $jf->tanggal;
            }

            $dataset = array(
                'label'             => $nama_user,
                'data'              => $data,
                'backgroundColor'   => $colors[$color_index],
                'borderWidth'       => 1
            );

            $datasets[] = $dataset;
            $color_index = ($color_index + 1) % count($colors);
        }

        $chart_data = array(
            'labels' => $labels,
            'datasets' => $datasets,
        );
        echo json_encode($chart_data);
    }
    
    public function userBoardList()
    {
        $today = date('Y-m-d');
        $tambahsatuhari = date('Y-m-d', strtotime("+1 day", strtotime($today)));

        $awal   = new DateTimeImmutable($today);
        $akhir  = new DateTimeImmutable($tambahsatuhari);
        $tawal = $awal->format('U');
        $takhir = $akhir->format('U');

        $data['title'] = "Userboard progress per Day";
        $data['prog'] = $this->m_dashboard->userListperDay($tawal, $takhir);

        $this->load->view('templates/grafik_header', $data);
        $this->load->view('dashboard/userBoardList', $data);
        $this->load->view('templates/grafik_footer');
    }
    
    public function sendEmail()
    {
        $sql = "SELECT * FROM `tb_user` WHERE (`role_id` = '9' OR `role_id` = '2' OR `role_id` = '1') AND `is_active` = '1'";
        $peg = $this->db->query($sql);
        
        // var_dump($peg->result());die();
        
        $tawal  = date('Y-m-d');
        $takhir = date('Y-m-d');
        
        $tanggal_awal   = new DateTime($tawal);
        $tanggal_akhir  = new DateTime($takhir);
        
        $jumlahHari = 0;
    
        // Iterasi setiap hari dari tanggal awal ke tanggal akhir
        while ($tanggal_awal <= $tanggal_akhir) {
                // Jika hari ini bukan hari Minggu (0 adalah Minggu, 6 adalah Sabtu)
            if ($tanggal_awal->format('w') != 0) {
                $jumlahHari++;
            }
                // Tambahkan 1 hari
            $tanggal_awal->modify('+1 day');
        }
        
        $targetHari = $jumlahHari;
        $dateRange  = $this->m_dashboard->dateRange($tawal,$takhir);
        
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        
        $style_judul = [
            'font'  => ['bold'  => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ]
        ];
        
        $style_col = [ 
            'font' => ['bold' => true], 
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $style_row = [ 
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A1', "Laporan follow-up customer " . $tawal . " S/D " . $takhir . " ( " . $targetHari . " Hari )"); 
        $sheet->mergeCells('A1:W3'); 
        $sheet->getStyle('A1')->getFont()->setBold(true); 
        $sheet->getStyle('A1')->applyFromArray($style_judul);
        
        $sheet->setCellValue('A4', "Nama User");
        $sheet->mergeCells('A4:A5');
        $sheet->setCellValue('B4', "Bagian");
        $sheet->mergeCells('B4:B5');
        
        $sheet->setCellValue('C4', "Telepon");
        $sheet->mergeCells('C4:E4');
        $sheet->setCellValue('C5', "Target");
        $sheet->setCellValue('D5', "Aktual");
        $sheet->setCellValue('E5', "Persentase (%)");
        
        $sheet->setCellValue('F4', "Whatsapp ALL");
        $sheet->mergeCells('F4:H4');
        $sheet->setCellValue('F5', "Target");
        $sheet->setCellValue('G5', "Aktual");
        $sheet->setCellValue('H5', "Persentase (%)");
        
        $sheet->setCellValue('I4', "WA Blast");
        $sheet->mergeCells('I4:K4');
        $sheet->setCellValue('I5', "Target");
        $sheet->setCellValue('J5', "Aktual");
        $sheet->setCellValue('K5', "Persentase (%)");
        
        $sheet->setCellValue('L4', "WA Blast Promo");
        $sheet->mergeCells('L4:N4');
        $sheet->setCellValue('L5', "Target");
        $sheet->setCellValue('M5', "Aktual");
        $sheet->setCellValue('N5', "Persentase (%)");
        
        $sheet->setCellValue('O4', "Tanya Barang");
        $sheet->mergeCells('O4:Q4');
        $sheet->setCellValue('O5', "Target");
        $sheet->setCellValue('P5', "Aktual");
        $sheet->setCellValue('Q5', "Persentase (%)");
        
        $sheet->setCellValue('R4', "Visit");
        $sheet->mergeCells('R4:T4');
        $sheet->setCellValue('R5', "Target");
        $sheet->setCellValue('S5', "Aktual");
        $sheet->setCellValue('T5', "Persentase (%)");
        
        $sheet->setCellValue('U4', "Omset Penjualan");
        $sheet->mergeCells('U4:W4');
        $sheet->setCellValue('U5', "Target");
        $sheet->setCellValue('V5', "Aktual");
        $sheet->setCellValue('W5', "Persentase (%)");
        
        $sheet->getStyle('A4')->applyFromArray($style_col);
        $sheet->getStyle('A5')->applyFromArray($style_col);
        
        $sheet->getStyle('B4')->applyFromArray($style_col);
        $sheet->getStyle('B5')->applyFromArray($style_col);
        
        $sheet->getStyle('C4')->applyFromArray($style_col);
        $sheet->getStyle('C5')->applyFromArray($style_col);
        
        $sheet->getStyle('D4')->applyFromArray($style_col);
        $sheet->getStyle('D5')->applyFromArray($style_col);
        
        $sheet->getStyle('E4')->applyFromArray($style_col);
        $sheet->getStyle('E5')->applyFromArray($style_col);
        
        $sheet->getStyle('F4')->applyFromArray($style_col);
        $sheet->getStyle('F5')->applyFromArray($style_col);
        
        $sheet->getStyle('G4')->applyFromArray($style_col);
        $sheet->getStyle('G5')->applyFromArray($style_col);
        
        $sheet->getStyle('H4')->applyFromArray($style_col);
        $sheet->getStyle('H5')->applyFromArray($style_col);
        
        $sheet->getStyle('I4')->applyFromArray($style_col);
        $sheet->getStyle('I5')->applyFromArray($style_col);
        
        $sheet->getStyle('J4')->applyFromArray($style_col);
        $sheet->getStyle('J5')->applyFromArray($style_col);
        
        $sheet->getStyle('K4')->applyFromArray($style_col);
        $sheet->getStyle('K5')->applyFromArray($style_col);
        
        $sheet->getStyle('L4')->applyFromArray($style_col);
        $sheet->getStyle('L5')->applyFromArray($style_col);
        
        $sheet->getStyle('M4')->applyFromArray($style_col);
        $sheet->getStyle('M5')->applyFromArray($style_col);
        
        $sheet->getStyle('N4')->applyFromArray($style_col);
        $sheet->getStyle('N5')->applyFromArray($style_col);
        
        $sheet->getStyle('O4')->applyFromArray($style_col);
        $sheet->getStyle('O5')->applyFromArray($style_col);
        
        $sheet->getStyle('P4')->applyFromArray($style_col);
        $sheet->getStyle('P5')->applyFromArray($style_col);
        
        $sheet->getStyle('Q4')->applyFromArray($style_col);
        $sheet->getStyle('Q5')->applyFromArray($style_col);
        
        $sheet->getStyle('R4')->applyFromArray($style_col);
        $sheet->getStyle('R5')->applyFromArray($style_col);
        
        $sheet->getStyle('S4')->applyFromArray($style_col);
        $sheet->getStyle('S5')->applyFromArray($style_col);
        
        $sheet->getStyle('T4')->applyFromArray($style_col);
        $sheet->getStyle('T5')->applyFromArray($style_col);
        
        $sheet->getStyle('U4')->applyFromArray($style_col);
        $sheet->getStyle('U5')->applyFromArray($style_col);
        
        $sheet->getStyle('V4')->applyFromArray($style_col);
        $sheet->getStyle('V5')->applyFromArray($style_col);
        
        $sheet->getStyle('W4')->applyFromArray($style_col);
        $sheet->getStyle('W5')->applyFromArray($style_col);
        
        $no = 1;
        $numrow = 6;
        
        foreach ($dateRange->result() AS $row) {
            $qry = "SELECT 
            SUM(CASE WHEN a.comment = '2' AND a.followup_value = 'Biasa' THEN a.transaction_value ELSE 0 END) AS count_penawaran_biasa,
            SUM(CASE WHEN a.comment = '2' AND a.followup_value = 'Promo' THEN a.transaction_value ELSE 0 END) AS count_penawaran_promo,
            SUM(CASE WHEN a.comment = '4' AND a.followup_value = 'Promo' THEN a.transaction_value ELSE 0 END) AS count_po_promo,
            SUM(CASE WHEN a.comment = '4' AND a.followup_value = 'Biasa' THEN a.transaction_value ELSE 0 END) AS count_po_biasa
            FROM tb_followup_detail a JOIN tb_followup b ON a.followup_id = b.followup_id
            WHERE b.add_by = ?
            AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y-%m-%d') BETWEEN '$tawal' AND '$takhir'";
    
            $krx = $this->db->query($qry, array($row->add_by))->row_array();
            
            $totalpo = $krx["count_po_promo"] + $krx["count_po_biasa"];
            
            if($row->format_customer == 'Telemarketing Horeka') {
                $ttelp = 80*$targetHari;
                $twb = 40*$targetHari;
                $twbp = 60*$targetHari;
                $twaa = 100*$targetHari;
                $ttb = 10*$targetHari;
                $tvs = 0*$targetHari;
                $tom = 3846154*$targetHari;
            } elseif ($row->format_customer == 'Telemarketing Foodpack') {
                $ttelp = 40*$targetHari;
                $twb = 0*$targetHari;
                $twbp = 0*$targetHari;
                $twaa = 20*$targetHari;
                $ttb = 5*$targetHari;
                $tvs = 0*$targetHari;
                $tom = 2400000*$targetHari;
            } elseif ($row->format_customer == 'Sales Horeka') {
                $ttelp = 7*$targetHari;
                $twb = 10*$targetHari;
                $twbp = 30*$targetHari;
                $twaa = 40*$targetHari;
                $ttb = 5*$targetHari;
                $tvs = 7*$targetHari;
                $tom = 3846154*$targetHari;
            } elseif ($row->format_customer == 'Website') {
                $ttelp = 20*$targetHari;
                $twb = 10*$targetHari;
                $twbp = 30*$targetHari;
                $twaa = 40*$targetHari;
                $ttb = 5*$targetHari;
                $tvs = 7*$targetHari;
                $tom = 3846154*$targetHari;
            } elseif ($row->format_customer == 'E-Commerce') {
                $ttelp = 0*$targetHari;
                $twb = 0*$targetHari;
                $twbp = 0*$targetHari;
                $twaa = 0*$targetHari;
                $ttb = 10*$targetHari;
                $tvs = 0*$targetHari;
                $tom = 3846154*$targetHari;
            }
            
            $totalWa = ($row->count_whatsapp_blast+$row->count_whatsapp_blast_promo);
            
            $sheet->setCellValue('A' . $numrow, $row->add_by);
            $sheet->setCellValue('B' . $numrow, $row->format_customer);
            
            $sheet->setCellValue('C' . $numrow, $ttelp);
            $sheet->setCellValue('D' . $numrow, $row->count_telp);
            if($ttelp != 0) {
                $sheet->setCellValue('E' . $numrow, number_format((($row->count_telp/$ttelp)*100), 2, ".", ".") . " %");
            } else  {
                $sheet->setCellValue('E' . $numrow, ("0 %"));
            }
            
            $sheet->setCellValue('F' . $numrow, $twaa);
            $sheet->setCellValue('G' . $numrow, ($row->count_whatsapp_blast+$row->count_whatsapp_blast_promo));
            if($twaa != 0) {
                $sheet->setCellValue('H' . $numrow, number_format((($totalWa/$twaa)*100), 2, ".", ".") . " %");
            } else {
                $sheet->setCellValue('H' . $numrow, ("0 %"));
            }
            
            $sheet->setCellValue('I' . $numrow, $twb);
            $sheet->setCellValue('J' . $numrow, $row->count_whatsapp_blast);
            if($twb != 0) {
                $sheet->setCellValue('K' . $numrow, number_format((($row->count_whatsapp_blast/$twb)*100), 2, ".", ".") . " %");
            } else {
                $sheet->setCellValue('K' . $numrow, ("0 %"));
            }
            
            $sheet->setCellValue('L' . $numrow, $twbp);
            $sheet->setCellValue('M' . $numrow, $row->count_whatsapp_blast_promo);
            if($twbp != 0) {
                $sheet->setCellValue('N' . $numrow, number_format((($row->count_whatsapp_blast_promo/$twbp)*100), 2, ".", ".") . " %");
            } else {
                $sheet->setCellValue('N' . $numrow, ("0 %"));
            }
            
            $sheet->setCellValue('O' . $numrow, $ttb);
            $sheet->setCellValue('P' . $numrow, $row->count_tanyabarang);
            if($ttb != 0) {
                $sheet->setCellValue('Q' . $numrow, number_format((($row->count_tanyabarang/$ttb)*100), 2, ".", ".") . " %");
            } else {
                $sheet->setCellValue('Q' . $numrow, ("0 %"));
            }
            
            $sheet->setCellValue('R' . $numrow, $tvs);
            $sheet->setCellValue('S' . $numrow, $row->count_visit);
            if($tvs != 0) {
                $sheet->setCellValue('T' . $numrow, number_format((($row->count_visit/$tvs)*100), 2, ".", ".") . " %");
            } else {
                $sheet->setCellValue('T' . $numrow, ("0 %"));
            }
            
            $sheet->setCellValue('U' . $numrow, $tom);
            $sheet->setCellValue('V' . $numrow, $totalpo);
            if($tom) {
                $sheet->setCellValue('W' . $numrow, number_format((($totalpo/$tom)*100), 2, ".", ".") . " %");
            } else {
                $sheet->setCellValue('W' . $numrow, ("0 %"));
            }
            
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('O' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('P' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('R' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('S' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('T' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('U' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('V' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('W' . $numrow)->applyFromArray($style_row);
            
            $numrow++;
        }
        
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(19);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(15);
        $sheet->getColumnDimension('S')->setWidth(15);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(15);
        $sheet->getColumnDimension('W')->setWidth(15);
        
        $sheet->getDefaultRowDimension()->setRowHeight(-1); //auto height

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE); //orientasi kertas

        // Set judul file excel nya
        $sheet->setTitle("LAPORAN FOLLOWUP CUSTOMER");
        
        $filePatch = './upload/file/'. $tawal .'.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePatch);
        
        $subject = "laporan Hasil Follow Up Customer";
        $isiMail = "Berikut merupakan hasil followup telemarketing hari ini. Silahkan didownload dan kemudian diolah\nYosshh... !";
        foreach($peg->result() AS $row){
            $email = $row->email;
            kiriMail($email, $subject, $isiMail, $filePatch);
        }
    }

}
