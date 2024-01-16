<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_master');
        $this->load->model('m_dashboard');
        is_logged_in();
    }

    public function summaryFollowup()
    {
        $data['title']  = 'Summary Followup';
        $data['user']   = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('master/master-summary', $data);
        $this->load->view('templates/footer');
    }

    function getsummaryFollowup($waktu)
    {
        $summary_data = $this->m_master->getSumfu($waktu);
        $data = array();

        foreach ($summary_data->result() as $r) {
            $data[] = array(
                'user'              => $r->add_by,
                'kontak'            => $r->kontak,
                'followup'          => $r->followup,
                'penawaran'         => $r->penawaran,
                'followup_penawaran' => $r->followup_penawaran,
                'order'             => $r->orders,
                'totals'            => ($r->kontak + $r->followup + $r->penawaran + $r->followup_penawaran + $r->orders)
            );
        }
        echo json_encode($data);
    }
    
    public function getRanking()
    {
        $dates = date('Y-m');
        
        $sql = "SELECT a.add_by, SUM(b.transaction_value) AS hitungNominal
        FROM tb_followup a 
        JOIN tb_followup_detail b ON a.followup_id = b.followup_id
        WHERE DATE_FORMAT(FROM_UNIXTIME(b.followup_date), '%Y-%m') = '$dates' AND b.comment = '4'
        GROUP BY a.add_by  
        ORDER BY `hitungNominal` DESC";
        
        $result = $this->db->query($sql);
        
        $data = array();
        $no = 1;
        
        foreach($result->result() AS $row) {
            $data[] = array(
                'no'    => $no++,
                'user'  => $row->add_by,
                'total' => "Rp. " . number_format($row->hitungNominal, 0, ".", ".")
            );
        }
        
        echo json_encode($data);
    }

    public function dataSumCustomer()
    {
        $id = $this->input->post('id');
        $users = $this->input->post('id');

        $today = date('Y-m-d');
        $tambahsatuhari = date('Y-m-d', strtotime("+1 day", strtotime($today)));

        $awal   = new DateTimeImmutable($today);
        $akhir  = new DateTimeImmutable($tambahsatuhari);

        $tawal = $awal->format('U');
        $takhir = $akhir->format('U');
        $thisMonth = date('m');
        $thisYear = date('Y');
        
        $this->load->model("m_dashboard");
        $sum_cust = $this->m_master->getJumlahCustomer($id, $tawal, $takhir);
        $jumlah_customer = count($sum_cust->result_array());

        $sum_kontak = $this->m_master->dataKontak($id, $tawal, $takhir);
        if(count($sum_kontak->result_array())) {
            $jumlah_kontak = count($sum_kontak->result_array());
        } else {
            $jumlah_kontak = '0';
        }
        
        $sum_semua = $this->m_dashboard->masterOpp($tawal, $takhir, $users);

        $sum_followup = $this->m_master->dataFollowup($id, $tawal, $takhir);
        $jumlah_followup = count($sum_followup->result_array());

        $sum_penawaran = $this->m_master->dataPenawaran($id, $tawal, $takhir);
        $jumlah_penawaran = count($sum_penawaran->result_array());

        $sum_fupenawaran = $this->m_master->datafuPenawaran($id, $tawal, $takhir);
        $jumlah_fupenawaran = count($sum_fupenawaran->result_array());
        
        $sum_order = $this->m_master->dataOrder($id, $tawal, $takhir);
        $jumlah_order = count($sum_order->result_array());

        $data_kategori = $this->m_master->dataKategori($id, $tawal, $takhir);
        $output = '';

        $output .='<div>
            <table width="100%" class="table table-borderless table-striped">
                <tr>
                    <th class="h5" colspan="3">' . $id . '</th>
                </tr>
                <tr>
                    <td>Jumlah Customer</td>
                    <td>:</td>
                    <td>' . $jumlah_customer . ' Customer</td>
                </tr>';
                foreach($sum_semua->result() AS $onu){
                $output .='<tr>
                    <td>' . $onu->prog . '</td>
                    <td>:</td>
                    <td>' . $onu->cprog . ' Customer</td>
                </tr>';
                }
            $output .='</table>
        </div>
        <div>
            <table class="table table-bordered table-striped tbs" width="100%" id="tbs">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($data_kategori->result() AS $bt) {
                        $output .='
                        <tr>
                            <td>' . $bt->nama . '</td>
                            <td>' . $bt->fu_id . '</td>
                        </tr>';
                    }
                $output .='</tbody>
            </table>
        </div>';

        echo $output;
    }
    
    public function zvoseFollowup()
    {
        $data['title'] = 'Data Followup';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('master/master-customer', $data);
        $this->load->view('templates/footer');
    }
    
    public function getmyCustomer()
    {
        $nama       = $this->session->userdata('nama_lengkap');
        $role_id    = $this->session->userdata('role_id');
        $this->load->model("m_followup");
        $customer = $this->m_followup->getCustomer($nama, $role_id);
        $data = array();
        foreach ($customer->result() as $row) {
            if($row->is_open == '1') {
                $status = "Open";
            } else {
                $status = "Close";
            }
            $data[] = array(
                'id'        => $row->followup_id,
                'name'      => $row->customer_name,
                'pic'       => $row->pic,
                'kontak'    => $row->phone,
                'status'    => $row->status,
                'date'      => date("Y-m-d", $row->date),
                'add_by'    => $row->add_by,
                'is_open'   => $row->is_open,
                'bar'       => '<small>Completion with: '. getStatusBar($row->followup_id) .'</small><div class="progress progress-mini"><div style="width: '. getStatusBar($row->followup_id) . ';" class="progress-bar"></div></div>',
                'bars'      => getStatusBar($row->followup_id),
                'ix_open'   => $status,
                'formatsx'   => $row->format_customer,
                'nominal'   => $row->nominalpo,
                'noso'      => $row->notansaksi
            );
        }
        echo json_encode($data);
    }

    public function viewDetail()
    {
        $id = $this->input->post('id');

        $row = $this->db->get_where('tb_followup', ['followup_id' => $id])->result_array();
        $row_dua = $this->db->get_where('tb_followup_detail', ['followup_id' => $id]);
        $this->load->model("m_followup");
        $konten = $this->m_followup->getTheMax($id)->row_array();;
        $html = '';

        foreach($row AS $r) {
            if($r['is_open'] == '0') {
                $st = '<span class="label label-danger">C L O S E</span>';
            } else {
                $st = '<span class="label label-success">O P E N</span>';
            }

            if($konten['comment'] == '0') {
                $kt = '<span class="label label-danger">Kontak</span>';
            } else if($konten['comment'] == '1') {
                $kt = '<span class="label label-warning">Followup</span>';
            } else if($konten['comment'] == '2') {
                $kt = '<span class="label label-success">Penawaran</span>';
            } else if($konten['comment'] == '3') {
                $kt = '<span class="label label-primary">Followup Penawaran</span>';
            } else if($konten['comment'] == '4') {
                $kt = '<span class="label label-info">Sudah PO/ Order</span>';
            }

            $html .='<div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Info Dasar</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Detail Info</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <table class="table table-striped table-borderless" width="100%">
                                <tr>
                                    <th>ID Followup</th>
                                    <td>:</td>
                                    <td>' . $r['followup_id'] . '</td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>:</td>
                                    <td>' . $r['customer_name'] . '</td>
                                </tr>
                                <tr>
                                    <th>Progress</th>
                                    <td>:</td>
                                    <td>' . getStatus($r['followup_id']) . '
                                        <dd>
                                            <div class="progress m-b-1">
                                                <div style="width: '. getStatusBar($r['followup_id']) .'" class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                            </div>
                                            <small>Project Remaining in <strong>' . getStatusBar($r['followup_id']) . '</strong>. dari 100%.</small>
                                        </dd>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tahap Followup</th>
                                    <td>:</td>
                                    <td>' . $kt . ' Tanggal  ' . date("Y-m-d H:i",$konten["followup_date"]) .'</td>
                                </tr>
                                <tr>
                                    <th>Status Followup</th>
                                    <td>:</td>
                                    <td>' . $st . '</td>
                                </tr>
                                <tr>
                                    <th>Notes</th>
                                    <td>:</td>
                                    <td>' . $konten["notes"] .'</td>
                                </tr>
                                <tr>
                                    <th>Follow-up By</th>
                                    <td>:</td>
                                    <td>' . $r['add_by'] . '</td>
                                </tr>';
                                if($r["is_open"] == '0' AND $r["close_with"] == '0') {
                                    $html .='<tr>
                                        <th>No. Transaksi/ No. SCO</th>
                                        <td>:</td>
                                        <td>' . $r["notansaksi"] . '</td>
                                    </tr>
                                    <tr>
                                        <th>Nominal</th>
                                        <td>:</td>
                                        <td>Rp. ' . number_format($r["nominalpo"], 0, ".", ".") . '</td>
                                    </tr>';
                                } else if(getStatusBar($r['followup_id']) == '60%' || getStatusBar($r['followup_id']) == '80%') {
                                    $html .='<tr>
                                        <th>No. Transaksi/ No. SCO</th>
                                        <td>:</td>
                                        <td>' . $r["nopenawaran"] . '</td>
                                    </tr>
                                    <tr>
                                        <th>Nominal</th>
                                        <td>:</td>
                                        <td>Rp. ' . number_format($r["nominalpenawaran"], 0, ".", ".") . '</td>
                                    </tr>';
                                }
                            $html .='</table>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <table class="table" width="100%">
                            <thead>
                                <th>Comment</th>
                                <th>Tanggal Followup</th>
                                <th>Methode</th>
                                <th>Due-date</th>
                                <th>Note</th>
                            </thead>
                            <tbody>';
                                foreach($row_dua->result() AS $rw) {
                                    if(($rw->comment == '0')) {
                                        $info = '<span class="label label-danger">Kontak</span>';
                                    } elseif(($rw->comment == '1')) {
                                        $info = '<span class="label label-warning">Followup</span>';
                                    } elseif(($rw->comment == '2')){
                                        $info = '<span class="label label-success">Penawaran</span>';
                                    } elseif(($rw->comment == '3')){
                                        $info = '<span class="label label-primary">Followup Penawaran</span>';
                                    } elseif(($rw->comment == '4')){
                                        $info = '<span class="label label-info">Sudah PO/ Order</span>';
                                    }
                                    $html .='<tr>
                                        <td>' . $info .'</td>
                                        <td>' . date("d-m-Y H:i", $rw->followup_date) .'</td>
                                        <td>' . $rw->followup_method . '</td>
                                        <td>' . date("d-m-Y H:i", $rw->due_date) .'</td>
                                        <td>' . $rw->notes .'</td>
                                    </tr>';
                                }
                            $html .='</tbody>
                        </table>
                    </div>
                </div>
            </div>';
        }

        echo $html;
    }
    
    public function getDataDay()
    {
        $tgl = $this->input->post('tgl');

        $dats = $this->m_master->getToday($tgl);

        $data = array();

        foreach ($dats->result() as $r) {
            $data[] = array(
                'user'              => $r->add_by,
                'kontak'            => $r->kontak,
                'followup'          => $r->followup,
                'penawaran'         => $r->penawaran,
                'followup_penawaran' => $r->followup_penawaran,
                'order'             => $r->orders,
                'totals'            => ($r->kontak + $r->followup + $r->penawaran + $r->followup_penawaran + $r->orders)
            );
        }
        echo json_encode($data);
    }

    public function sumTodays()
    {
        $tgl = date('Y-m-d');

        $dats = $this->m_master->getToday($tgl);

        $data = array();

        foreach ($dats->result() as $r) {
            $data[] = array(
                'user'              => $r->add_by,
                'kontak'            => $r->kontak,
                'followup'          => $r->followup,
                'penawaran'         => $r->penawaran,
                'followup_penawaran' => $r->followup_penawaran,
                'order'             => $r->orders,
                'totals'            => ($r->kontak + $r->followup + $r->penawaran + $r->followup_penawaran + $r->orders)
            );
        }
        echo json_encode($data);
    }
    
    public function board()
    {
        $cariTanggal = $this->input->post('tglpilih');

        $this->load->model("m_dashboard");
        $data['cra'] = $this->m_dashboard->creatingData($cariTanggal);
        if($cariTanggal != '') {
            $data['tgldipili']  = $cariTanggal;
        } else {
            $data['tgldipili']   = date('Y-m-d');
        }
        // echo json_encode($data['cra']);
        // die();

        $config['base_url'] = base_url('master/board');
        $config['total_rows'] = count($data['cra']);
        $config['per_page'] = 12;
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

        $data['cras'] = array_slice($data['cra'], $start, $config['per_page']);
        $data['links'] = $this->pagination->create_links();

        $data['title'] = 'User Board';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $data['sales'] = $this->m_dashboard->getSales();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('master/user-board', $data);
        $this->load->view('templates/footer');
    }
    
    public function activeoffer()
    {
        $data['title'] = 'Penawaran Aktif';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
        
        $data['pengguna'] = $this->m_master->listPenggunaaktif();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('master/penawaran-board', $data);
        $this->load->view('templates/footer');
    }
    
    public function exportDaily($tgl)
    {
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        // ambil data dari model
        $daily          = $this->m_dashboard->creatingData($tgl);

        // excel priview setting
        $style_col = [ //setting untuk header
            'font' => ['bold' => true], // Set font nya jadi bold
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

        $style_row = [ // setting untuk isi table
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

        $sheet->setCellValue('A1', "Daily Follow Up " . (string)$tgl); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:S1'); // Set Merge Cell pada kolom A1 sampai L1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1

        $sheet->setCellValue('A2', "NO");
        $sheet->mergeCells('A2:A3');
        $sheet->setCellValue('B2', "Nama karyawan");
        $sheet->mergeCells('B2:B3');
        $sheet->setCellValue('C2', "Jumlah Customer");
        $sheet->mergeCells('C2:C3');
        $sheet->setCellValue('D2', "Jumlah Follow Up");
        $sheet->mergeCells('D2:H2');
        $sheet->setCellValue('D3', "Visit"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "Whatsapp"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F3', "Telp"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "Email"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "Marketplace"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I2', "Tanya Barang");
        $sheet->mergeCells('I2:I3');
        $sheet->setCellValue('J2', "Wa Blast");
        $sheet->mergeCells('J2:J3');
        $sheet->setCellValue('K2', "Wa Blast Promo");
        $sheet->mergeCells('K2:K3');
        $sheet->mergeCells('L2:O2');
        $sheet->setCellValue('L2', "Penawarab");
        $sheet->setCellValue('L3', "Jumlah Penawaran Biasa");
        $sheet->setCellValue('M3', "Nominal");
        $sheet->setCellValue('N3', "Jumlah Penawaran Promo");
        $sheet->setCellValue('O3', "Nominal");
        $sheet->mergeCells('P2:S2');
        $sheet->setCellValue('P2', "PO");
        $sheet->setCellValue('P3', "Jumlah PO Biasa");
        $sheet->setCellValue('Q3', "Nominal");
        $sheet->setCellValue('R3', "Jumlah PO Promo");
        $sheet->setCellValue('S3', "Nominal");


        $sheet->getStyle('A2')->applyFromArray($style_col);
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B2')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C2')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D2')->applyFromArray($style_col);
        $sheet->getStyle('E2')->applyFromArray($style_col);
        $sheet->getStyle('F2')->applyFromArray($style_col);
        $sheet->getStyle('G2')->applyFromArray($style_col);
        $sheet->getStyle('H2')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I2')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J2')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K2')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L2')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M2')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N2')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        $sheet->getStyle('O2')->applyFromArray($style_col);
        $sheet->getStyle('O3')->applyFromArray($style_col);
        $sheet->getStyle('P2')->applyFromArray($style_col);
        $sheet->getStyle('P3')->applyFromArray($style_col);
        $sheet->getStyle('Q2')->applyFromArray($style_col);
        $sheet->getStyle('Q3')->applyFromArray($style_col);
        $sheet->getStyle('R2')->applyFromArray($style_col);
        $sheet->getStyle('R3')->applyFromArray($style_col);
        $sheet->getStyle('S2')->applyFromArray($style_col);
        $sheet->getStyle('S3')->applyFromArray($style_col);

        $no = 1;
        $numrow = 4;

        foreach ($daily as $row) {
            if($row["add_by"] != null) {
                $qry = "SELECT 
                SUM(CASE WHEN a.comment = '2' AND a.followup_value = 'Biasa' THEN a.transaction_value ELSE 0 END) AS count_penawaran_biasa,
                SUM(CASE WHEN a.comment = '2' AND a.followup_value = 'Promo' THEN a.transaction_value ELSE 0 END) AS count_penawaran_promo,
                SUM(CASE WHEN a.comment = '4' AND a.followup_value = 'Promo' THEN a.transaction_value ELSE 0 END) AS count_po_promo,
                SUM(CASE WHEN a.comment = '4' AND a.followup_value = 'Biasa' THEN a.transaction_value ELSE 0 END) AS count_po_biasa
                FROM tb_followup_detail a JOIN tb_followup b ON a.followup_id = b.followup_id
                WHERE b.add_by = ?
                AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y-%m-%d') = '$tgl'";
    
                $query = $this->db->query($qry, array($row["add_by"]))->row_array();
    
                $qery = "SELECT
                COUNT(CASE WHEN a.followup_value = 'Tanya Barang' THEN 1 END) AS count_tanya_barang,
                COUNT(CASE WHEN a.followup_value = 'Wa Blast' THEN 1 END) AS count_wa_blast,
                COUNT(CASE WHEN a.followup_value = 'Wa Blast Promo' THEN 1 END) AS count_wa_blast_promo
                FROM tb_followup_detail a JOIN tb_followup b ON a.followup_id = b.followup_id
                WHERE b.add_by = ?
                AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y-%m-%d') = '$tgl'";
    
                $skrull = $this->db->query($qery, array($row["add_by"]))->row_array();
    
                $kriss = "SELECT 
                    COUNT(CASE WHEN a.comment = '2' AND followup_value = 'Biasa' THEN 1 END) AS PenawaranBiasa,
                    COUNT(CASE WHEN a.comment = '2' AND followup_value = 'Promo' THEN 1 END) AS PenawaranPromo,
                    COUNT(CASE WHEN a.comment = '4' AND followup_value = 'Biasa' THEN 1 END) AS PoBiasa,
                    COUNT(CASE WHEN a.comment = '4' AND followup_value = 'Promo' THEN 1 END) AS PoPromo
                FROM tb_followup_detail a 
                JOIN tb_followup b ON a.followup_id = b.followup_id
                WHERE b.add_by = ? AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y-%m-%d') = ?";
    
                $skrill = $this->db->query($kriss, array($row["add_by"], $tgl))->row_array();
    
    
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $row["add_by"]);
                $sheet->setCellValue('C' . $numrow, $row["count_all"]);
                $sheet->setCellValue('D' . $numrow, $row["count_visit"]);
                $sheet->setCellValue('E' . $numrow, $row["count_whatsapp"]);
                $sheet->setCellValue('F' . $numrow, $row["count_telp"]);
                $sheet->setCellValue('G' . $numrow, $row["count_email"]);
                $sheet->setCellValue('H' . $numrow, $row["count_marketplace"]);
                $sheet->setCellValue('I' . $numrow, $skrull["count_tanya_barang"]);
                $sheet->setCellValue('J' . $numrow, $skrull["count_wa_blast"]);
                $sheet->setCellValue('K' . $numrow, $skrull["count_wa_blast_promo"]);
                $sheet->setCellValue('L' . $numrow, $skrill["PenawaranBiasa"]);
                $sheet->setCellValue('M' . $numrow, $query["count_penawaran_biasa"]);
                $sheet->setCellValue('N' . $numrow, $skrill["PenawaranPromo"]);
                $sheet->setCellValue('O' . $numrow, $query["count_penawaran_promo"]);
                $sheet->setCellValue('P' . $numrow, $skrill["PoBiasa"]);
                $sheet->setCellValue('Q' . $numrow, $query["count_po_biasa"]);
                $sheet->setCellValue('R' . $numrow, $skrill["PoPromo"]);
                $sheet->setCellValue('S' . $numrow, $query["count_po_promo"]);
                
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
    
                $no++;
                $numrow++;
            }
        }

        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(10); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(25); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(25); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(35); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('N')->setWidth(35); // Set width kolom E
        $sheet->getColumnDimension('O')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('P')->setWidth(35); // Set width kolom E
        $sheet->getColumnDimension('Q')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('R')->setWidth(35); // Set width kolom E
        $sheet->getColumnDimension('S')->setWidth(20); // Set width kolom E

        $sheet->getDefaultRowDimension()->setRowHeight(-1); //auto height

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE); //orientasi kertas

        // Set judul file excel nya
        $sheet->setTitle($tgl);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Daily FU ' . $tgl . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    
    public function fullscreenBoard()
    {
        $cariTanggal = "2023-10-16";
        // $cariTanggal = date('Y-m-d');
        // $data['bd'] = $this->m_dashboard->creatingData($cariTanggal);
        $this->load->view('master/fullscreenboard');
    }

    public function slider_sse()
    {
        // Set the appropriate headers for SSE
        // Retrieve the latest slider data
        $html = $this->getSliderHtml();

        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'html' => $html
        ]);
    }

    public function getSliderHtml()
    {
        $html = '';
        $cariTanggal = date("Y-m-d");
        $bd = $this->m_dashboard->creatingData($cariTanggal);
        $totalCount = count($bd);
        $no = 1;
        foreach ($bd as $row) {
            // if ($row["add_by"] != null) {
                $gambar = $this->db->get_where('tb_user', ['user_nama' => $row["add_by"]])->row_array();
                $html .= '<div class="carousel-item ' . ($no == 1 ? 'active' : '') . '" data-bs-interval="10000">
                    <div class="card mb-5">
                        <div class="card-header" style="display: flex; align-items: center; width: 100%; column-gap: 10px; overflow:visible; ">
                            <div class="card-header-img">
                                <img src="' . base_url('assets/img/gallery/') . $gambar['photo'] . '" style="width: 75px; border-radius:100%" class="mb-2">
                            </div>
                            <div class="pt-2">
                                <h5 style="font-weight: bold; text-transform: uppercase;" class="mb-2">' . $row["add_by"] . '</h5>
                                <p>' . $row["format_customer"] . '</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-lg-4">
                                    <table class="table" role="ALL" style="color: var(--color-text);">
                                        <tr>
                                            <td width="45%">Jlh Customer</td>
                                            <td>:</td>
                                            <td>' . $row["count_all"] . ' Customer</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i> Visit</td>
                                            <td>:</td>';
                                            if ($row["format_customer"] == 'Website' || $row["format_customer"] == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row["count_visit"] / 7) * 100), 2, ".", ".") . '%  <i class="fa fa-arrow-circle-right"></i> ' . $row["count_visit"] .'/ 7</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_visit"] / 7) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row["count_visit"] . '</td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa-brands fa-whatsapp"></i> Total Whatsapp</td>
                                            <td>:</td>';
                                            if($row["format_customer"] == 'Telemarketing Horeka') {
                                                $html .='<td>
                                                    <small>' . number_format((($row["wa_foodpack"] / 102) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["wa_foodpack"] . '/ 102</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["wa_foodpack"] / 102) * 100) . '% " class="progress-bar';
                                                        if((($row["wa_foodpack"] / 102) * 100) < 100){ $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .='<td>' . $row["wa_foodpack"] . '</td>';
                                            }
                                        $html .='</tr>
                                        <tr>
                                            <td><i class="fa fa-phone"></i> Telp</td>
                                            <td>:</td>';
                                            if ($row["format_customer"] == 'Telemarketing Horeka') {
                                            $html .= '<td><small>' . number_format((($row["count_telp"] / 80) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_telp"] . '/ 80</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_telp"] / 80) * 100) . '% " class="progress-bar';
                                                        if((($row["count_telp"] / 80) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Telemarketing Foodpack') {
                                                $html .= '<td><small>' . (($row["count_telp"] / 40) * 100) . '% | ' . $row["count_telp"] . '/ 40</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_telp"] / 40) * 100) . '%" class="progress-bar';
                                                        if((($row["count_telp"] / 40) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Website') {
                                                $html .= '<td>
                                                    <small>' . (($row["count_telp"] / 20) * 100) . '% | ' . $row["count_telp"] . '/ 20</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_telp"] / 20) * 100) . '%" class="progress-bar'; 
                                                        if((($row["count_telp"] / 20) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . (($row["count_telp"] / 7) * 100) . '% | ' . $row["count_telp"] . '/ 7</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_telp"] / 7) * 100) . '%" class="progress-bar'; 
                                                        if((($row["count_telp"] / 7) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif($row["format_customer"] == 'Showroom') {
                                                $html .='<td>
                                                    <small>' . number_format((($row["count_telp"]/ 30) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_telp"] . '/ 30</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_telp"]/ 30) * 100) . '%" class="progress-bar'; 
                                                        if((($row["count_telp"]/ 30) * 100) < 100) { $html .=' prgress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row["count_telp"] . ' </td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa fa-envelope"></i> Email</td>
                                            <td>:</td>
                                            <td>' . $row["count_email"] . '</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa-brands fa-gittip"></i> By Marketplace</td>
                                            <td>:</td>
                                            <td>' . $row["count_marketplace"] . '</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-file-text-o"></i> Penawaran</td>
                                            <td>:</td>
                                            <td>' . $row["count_penawaran"] . '</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-shopping-cart"></i> PO</td>
                                            <td>:</td>
                                            <td>' . $row["count_po"] . '</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col col-lg-4">
                                    <table class="table">
                                        <tr>
                                            <td width="40%"><i class="fa fa-comments-o"></i> Tanya Barang</td>
                                            <td>:</td>';
                                            if ($row["format_customer"] == 'Telemarketing Horeka' || $row["format_customer"] == 'E-Commerce') {
                                                $html .= '<td>
                                                    <small>' . (($row["count_tanyabarang"] / 10) * 100) . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_tanyabarang"] .'/ 10</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_tanyabarang"] / 10) * 100) . '% " class="progress-bar'; 
                                                        if((($row["count_tanyabarang"] / 10) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Telemarketing Foodpack' || $row["format_customer"] == 'Website' || $row["format_customer"] == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . (($row["count_tanyabarang"] / 5) * 100) . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_tanyabarang"] . '/ 5</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_tanyabarang"] / 5) * 100) . '% " class="progress-bar'; 
                                                        if((($row["count_tanyabarang"] / 5) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row["count_tanyabarang"] . '</td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa fa-bullhorn"></i> Wa Blast</td>
                                            <td>:</td>';
                                            if ($row["format_customer"] == 'Telemarketing Horeka') {
                                                $html .= '<td>
                                                    <small>' . (($row["count_whatsapp_blast"] / 40) * 100) . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_whatsapp_blast"] . '/ 40</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_whatsapp_blast"] / 40) * 100) . '% " class="progress-bar'; 
                                                        if((($row["count_whatsapp_blast"] / 40) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Telemarketing Foodpack') {
                                                $html .= '<td>
                                                    <small>' . (($row["wa_foodpack"] / 20) * 100) . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["wa_foodpack"] . '/ 20</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["wa_foodpack"] / 40) * 100) . '% " class="progress-bar'; 
                                                        if((($row["wa_foodpack"] / 40) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Website' || $row["format_customer"] == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . (($row["count_whatsapp_blast"] / 30) * 100) . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_whatsapp_blast"] . '/ 30</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_whatsapp_blast"] / 30) * 100) . '% " class="progress-bar'; 
                                                        if((($row["count_whatsapp_blast"] / 30) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row["count_whatsapp_blast"] . '</td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa fa-paper-plane-o"></i> Wa Blast Promo</td>
                                            <td>:</td>';
                                            if ($row["format_customer"] == 'Telemarketing Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row["count_whatsapp_blast_promo"] / 60) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_whatsapp_blast_promo"] . '/ 60</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_whatsapp_blast_promo"] / 60) * 100) . '% " class="progress-bar'; 
                                                        if((($row["count_whatsapp_blast_promo"] / 60) * 100) < 100) { $html .=' progress-bar-animated progress-bar-striped progress-bar-danger'; } $html .='"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row["format_customer"] == 'Website' || $row["format_customer"] == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row["count_whatsapp_blast_promo"] / 30) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row["count_whatsapp_blast_promo"] . '/ 30</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row["count_whatsapp_blast_promo"] / 30) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row["count_whatsapp_blast_promo"] . '</td>';
                                            }
                                        $html .= '</tr>
                                    </table>
                                </div>
                                <div class="col col-lg-4">
                                    <table class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Jenis</th>
                                                <th>Qty</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Penawaran Biasa</th>
                                                <th>' . $row["PenawaranBiasa"] . " Lembar" . '</th>
                                                <th>' . "Rp. " . number_format($row["count_penawaran_biasa"], 0, ".", ".") . '</th>
                                            </tr>
                                            <tr>
                                                <th>Penawaran Promo</th>
                                                <td>' . $row["PenawaranPromo"] . " Lembar" . '</td>
                                                <td>' . "Rp. " . $row["count_penawaran_promo"] . '</td>
                                            </tr>
                                            <tr>
                                                <th>Po Biasa</th>
                                                <td>' . $row["PoBiasa"] . " Lembar" . '</td>
                                                <td>' . "Rp. " . number_format($row["count_po_biasa"], 0, ",", ".") . '</td>
                                            </tr>
                                            <tr>
                                                <th>Po Promo</th>
                                                <td>' . $row["PoPromo"] . " Lembar" . '</td>
                                                <td>' . "Rp. " . number_format($row["count_po_promo"], 0, ",", ".") . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <table class="table table-striped table-borderless">
                                        <tr class="table-warning text-center" style="align: ceter;">
                                            <th colspan="3">PO BULAN INI</th>
                                        </tr>
                                        <tr class="table-primary">
                                            <th>Lembar PO</th>
                                            <th>:</th>
                                            <th>' . countPo($row["add_by"], date("m")) . ' Lembar</th>
                                        </tr>
                                        <tr class="table-info">
                                            <th>Nominal PO Bulan ini</th>
                                            <th>:</th>
                                            <th>Rp. ' . number_format(sumPo($row["add_by"], date("m")), 0, ".", ".") . '</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            $no++;
        }

        return [
            'html' => $html,
            'countData' => $totalCount
        ];
    }
    
    public function clops()
    {
        $data['title'] = 'Opportunities';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
        
        $data['clwith'] = $this->m_master->get_closewith();
        $data['nompo'] = $this->m_master->nominalPo();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('master/close-board', $data);
        $this->load->view('templates/footer');
    }
    
    public function detailClose($id)
    {
        $key = "sifupass";
        $decryptedData = decryptData($id, $key);
        
        $data['title'] = 'Closed Opportunities';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
        $data['type'] = $decryptedData;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('master/detail-board', $data);
        $this->load->view('templates/footer');
    }
    
    public function dataclose($id)
    {
        $key = "sifupass";
        $decryptedData = decryptData($id, $key);
        
        $list = $this->db->get_where('tb_followup', ['close_with' => $decryptedData, 'MONTH(FROM_UNIXTIME(date))' => date('m'), 'YEAR(FROM_UNIXTIME(date))' => date('Y')]);
        
        $data = array();
        foreach($list->result() AS $r){
            $sql    = "SELECT * FROM `tb_followup_detail` WHERE followup_id = '" . $r->followup_id . "' AND followup_date = (SELECT MAX(followup_date) FROM tb_followup_detail WHERE followup_id = '" . $r->followup_id . "')";
            $dbd    = $this->db->query($sql)->row_array();
            $bars = getStatusBar($r->followup_id);
            
            $data[] = array(
                'tgl'   => date("Y-m-d", $r->date),
                'nama'  => $r->customer_name,
                'bar'   => "<small>Completion with: $bars</small><div class=\"progress progress-mini\"><div style=\"width: $bars;\" class=\"progress-bar\"></div></div>",
                'notes' => $dbd['notes'],
                'orang' => $r->add_by,
                'formatx' => $r->format_customer
            );
        }
        
        echo json_encode($data);
    }
    
    public function showRangeView()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $tawal      = $this->input->post('tglawal');
            $takhir     = $this->input->post('tglakhr');
            //convert to date format heula
            $tglawal    = new DateTime($this->input->post('tglawal'));
            $tglakhr    = new DateTime($this->input->post('tglakhr'));
            
            $jumlahHari = 0;
    
            // Iterasi setiap hari dari tanggal awal ke tanggal akhir
            while ($tglawal <= $tglakhr) {
                // Jika hari ini bukan hari Minggu (0 adalah Minggu, 6 adalah Sabtu)
                if ($tglawal->format('w') != 0) {
                    $jumlahHari++;
                }
                // Tambahkan 1 hari
                $tglawal->modify('+1 day');
            }
            
            //$jumlahHari adalah jumlah hari dari tanggal awal sampai tanggal akhir yang dipilih
            $html = '';
            
            $dateRange = $this->m_dashboard->dateRange($tawal,$takhir);
            
            // $data = array();
            $html .= '<div class="row">';
            foreach($dateRange->result() AS $row) {
                $gambar = $this->db->get_where('tb_user', ['user_nama' => $row->add_by])->row_array();
                $html .= '<div class="col-lg-4">
                    <div class="card mb-5 animated fadeInRight">
                        <div class="card-header" style="display: flex; align-items: center; width: 100%; column-gap: 10px; overflow:visible; ">
                            <div class="card-header-img">
                                <img src="' . base_url('assets/img/gallery/') . $gambar['photo'] . '" style="width: 75px; border-radius:100%" class="mb-2">
                            </div>
                            <div class="pt-2">
                                <h5 style="font-weight: bold; text-transform: uppercase;" class="mb-2">' . $row->add_by . '</h5>
                                <p>' . $row->format_customer . '</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table" role="ALL" style="color: var(--color-text);">
                                        <tr>
                                            <td width="45%">Jlh Customer</td>
                                            <td>:</td>
                                            <td>' . $row->count_all . ' Customer</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i> Visit</td>
                                            <td>:</td>';
                                            if ($row->format_customer == 'Website' || $row->format_customer == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_visit / (7*$jumlahHari)) * 100), 2, ".", ".") . '%  <i class="fa fa-arrow-circle-right"></i> ' . $row->count_visit .'/' . (7*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_visit / (7*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row->count_visit . '</td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa-brands fa-whatsapp"></i> Total Whatsapp</td>
                                            <td>:</td>';
                                            if($row->format_customer == 'Telemarketing Horeka') {
                                                $html .='<td>
                                                    <small>' . number_format((($row->wa_foodpack / (102*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->wa_foodpack . '/' . (102*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->wa_foodpack / (102*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .='<td>' . $row->wa_foodpack . '</td>';
                                            }
                                        $html .='</tr>
                                        <tr>
                                            <td><i class="fa fa-phone"></i> Telp</td>
                                            <td>:</td>';
                                            if ($row->format_customer == 'Telemarketing Horeka') {
                                            $html .= '<td><small>' . number_format((($row->count_telp / (80*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_telp . '/' . (80*$jumlahHari) .'</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_telp / (80*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Telemarketing Foodpack') {
                                                $html .= '<td><small>' . number_format((($row->count_telp / (40*$jumlahHari)) * 100), 2, ".", ".") . '% | ' . $row->count_telp . '/'. (40*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_telp / (40*$jumlahHari)) * 100) . '%" class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Website') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_telp / (20*$jumlahHari)) * 100), 2, ".", ".") . '% | ' . $row->count_telp . '/' . (20*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_telp / (20*$jumlahHari)) * 100) . '%" class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_telp / (7*$jumlahHari)) * 100), 2, ".", ".") . '% | ' . $row->count_telp . '/' . (7*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_telp / (7*$jumlahHari)) * 100) . '%" class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif($row->format_customer == 'Showroom') {
                                                $html .='<td>
                                                    <small>' . number_format((($row->count_telp/ (30*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_telp . '/' . (30*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_telp/ (30*$jumlahHari)) * 100) . '%" class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row->count_telp . ' </td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa fa-envelope"></i> Email</td>
                                            <td>:</td>
                                            <td>' . $row->count_email . '</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa-brands fa-gittip"></i> By Marketplace</td>
                                            <td>:</td>
                                            <td>' . $row->count_marketplace . '</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-file-text-o"></i> Penawaran</td>
                                            <td>:</td>
                                            <td>' . $row->count_penawaran . '</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-shopping-cart"></i> PO</td>
                                            <td>:</td>
                                            <td>' . $row->count_po . '</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col col-lg-12">
                                    <table class="table">
                                        <tr>
                                            <td width="40%"><i class="fa fa-comments-o"></i> Tanya Barang</td>
                                            <td>:</td>';
                                            if ($row->format_customer == 'Telemarketing Horeka' || $row->format_customer == 'E-Commerce') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_tanyabarang / (10*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_tanyabarang .'/' . (10*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_tanyabarang / (10*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Telemarketing Foodpack' || $row->format_customer == 'Website' || $row->format_customer == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_tanyabarang / (5*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_tanyabarang . '/' . (5*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_tanyabarang / (5*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row->count_tanyabarang . '</td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa fa-bullhorn"></i> Wa Blast</td>
                                            <td>:</td>';
                                            if ($row->format_customer == 'Telemarketing Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_whatsapp_blast / (40*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_whatsapp_blast . '/' . (40*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_whatsapp_blast / (40*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Telemarketing Foodpack') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->wa_foodpack / (20*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->wa_foodpack . '/' . (20*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->wa_foodpack / (40*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Website' || $row->format_customer == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_whatsapp_blast / (30*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_whatsapp_blast . '/' . (30*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_whatsapp_blast / (30*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row->count_whatsapp_blast . '</td>';
                                            }
                                        $html .= '</tr>
                                        <tr>
                                            <td><i class="fa fa-paper-plane-o"></i> Wa Blast Promo</td>
                                            <td>:</td>';
                                            if ($row->format_customer == 'Telemarketing Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_whatsapp_blast_promo / (60*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_whatsapp_blast_promo . '/' . (60*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_whatsapp_blast_promo / (60*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } elseif ($row->format_customer == 'Website' || $row->format_customer == 'Sales Horeka') {
                                                $html .= '<td>
                                                    <small>' . number_format((($row->count_whatsapp_blast_promo / (30*$jumlahHari)) * 100), 2, ".", ".") . '% <i class="fa fa-arrow-circle-right"></i> ' . $row->count_whatsapp_blast_promo . '/' . (30*$jumlahHari) . '</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: ' . (($row->count_whatsapp_blast_promo / (30*$jumlahHari)) * 100) . '% " class="progress-bar"></div>
                                                    </div>
                                                </td>';
                                            } else {
                                                $html .= '<td>' . $row->count_whatsapp_blast_promo . '</td>';
                                            }
                                        $html .= '</tr>
                                    </table>
                                </div>
                                <div class="col col-lg-12">
                                    <table class="table table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Jenis</th>
                                                <th>Qty</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Penawaran Biasa</th>
                                                <th>' . $row->PenawaranBiasa . " Lembar" . '</th>
                                                <th>' . "Rp. " . number_format($row->count_penawaran_biasa, 0, ".", ".") . '</th>
                                            </tr>
                                            <tr>
                                                <th>Penawaran Promo</th>
                                                <td>' . $row->PenawaranPromo . " Lembar" . '</td>
                                                <td>' . "Rp. " . $row->count_penawaran_promo . '</td>
                                            </tr>
                                            <tr>
                                                <th>Po Biasa</th>
                                                <td>' . $row->PoBiasa . " Lembar" . '</td>
                                                <td>' . "Rp. " . number_format($row->count_po_biasa, 0, ",", ".") . '</td>
                                            </tr>
                                            <tr>
                                                <th>Po Promo</th>
                                                <td>' . $row->PoPromo . " Lembar" . '</td>
                                                <td>' . "Rp. " . number_format($row->count_po_promo, 0, ",", ".") . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>';
            }
            $html .='</div>';
            
            echo $html;
            
        } else {
            // Metode HTTP selain POST tidak diizinkan
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Metode HTTP tidak diizinkan']));
        }
    }
    
    public function laporanFollowup($strings)
    {
        $key = "sifupass";
        $decryptedData = decryptData($strings, $key);
        
        $tawal  = explode("|", $decryptedData)[0];
        $takhir = explode("|", $decryptedData)[1];
        
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
    
            // $qery = "SELECT
            // COUNT(CASE WHEN a.followup_value = 'Tanya Barang' THEN 1 END) AS count_tanya_barang,
            // COUNT(CASE WHEN a.followup_value = 'Wa Blast' THEN 1 END) AS count_wa_blast,
            // COUNT(CASE WHEN a.followup_value = 'Wa Blast Promo' THEN 1 END) AS count_wa_blast_promo
            // FROM tb_followup_detail a JOIN tb_followup b ON a.followup_id = b.followup_id
            // WHERE b.add_by = ?
            // AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y-%m-%d') BETWEEN '$tawal' AND '$takhir'";
    
            // $skrull = $this->db->query($qery, array($row->add_by))->row_array();
    
            // $kriss = "SELECT 
            //     COUNT(CASE WHEN a.comment = '2' AND followup_value = 'Biasa' THEN 1 END) AS PenawaranBiasa,
            //     COUNT(CASE WHEN a.comment = '2' AND followup_value = 'Promo' THEN 1 END) AS PenawaranPromo,
            //     COUNT(CASE WHEN a.comment = '4' AND followup_value = 'Biasa' THEN 1 END) AS PoBiasa,
            //     COUNT(CASE WHEN a.comment = '4' AND followup_value = 'Promo' THEN 1 END) AS PoPromo
            // FROM tb_followup_detail a 
            // JOIN tb_followup b ON a.followup_id = b.followup_id
            // WHERE b.add_by = ? AND DATE_FORMAT(FROM_UNIXTIME(a.followup_date), '%Y-%m-%d') BETWEEN '$tawal' AND '$takhir'";
    
            // $skrill = $this->db->query($kriss, array($row->add_by))->row_array();
            
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

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="LAPORAN FU CUSTOMER ' . $tawal . ' - ' . $takhir . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    
    public function listPenawaran()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $tawal      = $this->input->post('tglawal');
            $takhir     = $this->input->post('tglakhr');
            $pengguna   = $this->input->post('pengguna');
            
            $html       = '';
            $dataPenawaran = $this->m_master->listPenawaranAktif($tawal, $takhir, $pengguna);
            
            $html .='<div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>ID Penawaran</th>
                    <th>Nominal Penawaran</th>
                    <th>User</th>
                    <th>Notes</th>
                    <th>Status</th>
                </thead>
                <tbody>';
            if($dataPenawaran->num_rows() > 0) {
                foreach ($dataPenawaran->result() AS $row) {
                    if($row->followup_value == 'Biasa') {
                        $classed = 'label-primary';
                    } else {
                        $classed = 'label-info';
                    }
                    $gambar = $this->db->get_where('tb_user', ['user_nama' => $row->add_by])->row_array();
                    $html .= '<tr>
                        <td class="project-status">' . $row->tglPenawaran . '</td>
                        <td class="project-title">' . $row->customer_name . '</td>
                        <td class="project-title">' . strtoupper($row->transaction_id) . '</td>
                        <td class="project-completion">Rp. ' . number_format($row->transaction_value, 0, ",", ".") . '</td>
                        <td class="project-people" style="text-align: left"><img alt="image" class="rounded-circle border border-info" src="' . base_url('assets/img/gallery/') . $gambar['photo'] . '"> ' . strtoupper($row->add_by) . '</td>
                        <td class="project-status">
                            <div id="longTextCell" class="text-container">
                                <span onclick="toggleText(this)" class="collapsed">' . $row->notes . '</span>
                                <span class="expanded">' . $row->notes . '</span>
                            </div>
                            
                        </td>
                        <td class="project-status"><span class="label ' . $classed . '">' . $row->followup_value . '</span></td>
                    </tr>';
                }
            } else {
                $html .='<tr>
                <td class="project-status" colspan="7">Data tidak ditemukan !!!</td>
                </tr>';
            }
            
            $html .='</tbody></table></div>';
            
            echo $html;
        } else {
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Metode HTTP tidak diizinkan']));
        }
    }
    
    public function downloadListPenawaran($strings)
    {
        $key = "sifupass";
        $decryptedData = decryptData($strings, $key);
        
        $tawal  = explode("|", $decryptedData)[0];
        $takhir = explode("|", $decryptedData)[1];
        $pengguna   = explode("|", $decryptedData)[2];
        
        
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        
        $dataPenawaran = $this->m_master->listPenawaranAktif($tawal, $takhir, $pengguna);
        
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
        
        $sheet->setCellValue('A1', "Laporan List Penawaran " . $tawal . " S/D " . $takhir . " ( " . $pengguna . " )"); 
        $sheet->mergeCells('A1:H1'); 
        $sheet->getStyle('A1')->getFont()->setBold(true); 
        $sheet->getStyle('A1')->applyFromArray($style_judul);
        
        $sheet->setCellValue('A2', "No.");
        $sheet->setCellValue('B2', "Tanggal");
        $sheet->setCellValue('C2', "Customer");
        $sheet->setCellValue('D2', "ID Penawaran");
        $sheet->setCellValue('E2', "Nominal Penawaran");
        $sheet->setCellValue('F2', "User");
        $sheet->setCellValue('G2', "Notes");
        $sheet->setCellValue('H2', "Status");
        
        $sheet->getStyle('A2')->applyFromArray($style_col);
        $sheet->getStyle('B2')->applyFromArray($style_col);
        $sheet->getStyle('C2')->applyFromArray($style_col);
        $sheet->getStyle('D2')->applyFromArray($style_col);
        $sheet->getStyle('E2')->applyFromArray($style_col);
        $sheet->getStyle('F2')->applyFromArray($style_col);
        $sheet->getStyle('G2')->applyFromArray($style_col);
        $sheet->getStyle('H2')->applyFromArray($style_col);
        
        $no = 1;
        $numrow = 3;
        
        foreach ($dataPenawaran->result() AS $row) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $row->tglPenawaran);
            $sheet->setCellValue('C' . $numrow, $row->customer_name);
            $sheet->setCellValue('D' . $numrow, $row->transaction_id);
            $sheet->setCellValue('E' . $numrow, $row->transaction_value);
            $sheet->setCellValue('F' . $numrow, $row->add_by);
            $sheet->setCellValue('G' . $numrow, $row->notes);
            $sheet->setCellValue('H' . $numrow, $row->followup_value);
            
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            
            $no++;
            $numrow++;
        }
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(19);
        $sheet->getColumnDimension('C')->setWidth(33);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        
        $sheet->getDefaultRowDimension()->setRowHeight(-1); //auto height

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE); //orientasi kertas

        // Set judul file excel nya
        $sheet->setTitle("Penawaran Aktif");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan List Penawaran Aktif ' . $pengguna . ' Dari  ' . $tawal . ' - ' . $takhir . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    
    public function detailFormat()
    {
        $bulan          = date('m');
        $formatcustomer = $this->input->post('formatCustomer');
        $role           = $this->db->get_where('user_role', ['role' => $formatcustomer])->row_array();
        $pengguna       = $this->db->get_where('tb_user', ['is_active' => '1', 'role_id' => $role['role_id']]);
        
        $html ='';
        $html .='<table class="table table-bordered table-striped animated bounceInUp ">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Bagian ' . $formatcustomer . '</th>
                </tr>
                <tr>
                    <th>Nama user</th>
                    <th>Nominal Achievement</th>
                    <th>Number of PO Sheets</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
            foreach($pengguna->result() AS $p) {
                $html .='<tr>
                    <td>' . $p->user_nama . '</td>
                    <td>Rp. ' . number_format(sumPo($p->user_nama, $bulan), 0, ".", ".") . '</td>
                    <td>' . number_format(countPo($p->user_nama, $bulan), 0, ".", ".") . ' sheets</td>
                    <td><button class="btn btn-xs btn-success btn-block patarida"><i class="fa fa-eye"></i> Detail</button></td>
                </tr>';
            }
        $html .='</table>';
        
        echo $html;
    }
}
