<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Followup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // $this->load->model("m_dashboard");
        $this->load->model("m_followup");
    }

    public function liste()
    {
        $data['title'] = 'List Follow Up';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('followup/list-customer', $data);
        $this->load->view('templates/footer');
    }

    public function getmyCustomer()
    {
        $nama       = $this->session->userdata('nama_lengkap');
        $role_id    = $this->session->userdata('role_id');

        $customer = $this->m_followup->getCustomer($nama, $role_id);
        $data = array();
        foreach ($customer->result() as $row) {
            if($row->is_open == '0'){
                $f_status = "CLOSE";
            } else if($row->is_open == '1') {
                $f_status = "OPEN";
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
                'f_status'  => $f_status
            );
        }
        echo json_encode($data);
    }
    
    function dataFollowupku()
    {
        $nama       = $this->session->userdata('nama_lengkap');
        $dataku     = $this->db->get_where('tb_followup', ['add_by' => $nama]);
        
        $html=[];
        foreach($dataku->result() AS $row){
            array_push($html, $row->customer_name);
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($html) ;
    }

    public function newCustomerFu()
    {
        $this->form_validation->set_rules('nama', 'Nama customer', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori customer', 'trim|required');
        $this->form_validation->set_rules('pic', 'Kategori customer', 'trim|required');
        $this->form_validation->set_rules('kontak', 'Kontak customer', 'trim|numeric|min_length[8]');
        $this->form_validation->set_rules('tanggal', 'tanggal input', 'trim|required');
        $this->form_validation->set_rules('jam', 'jam input customer', 'trim|required');
        $this->form_validation->set_rules('format', 'format', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $data['title']  = 'List Follow Up';
            $data['user']   = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
            $data['catgr']  = $this->db->get_where('tb_category', ['bagian' => $this->session->userdata('role_id')]);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/headbar', $data);
            $this->load->view('followup/new-customer', $data);
            $this->load->view('templates/footer');
        } else {
            # code...
            $nmcustomer = $this->input->post('nama');
            $kategori   = $this->input->post('kategori');
            $pic        = $this->input->post('pic');
            $kontak     = $this->input->post('kontak');
            $tanggal    = date_format(date_create($this->input->post('tanggal')), "Y-m-d");
            $jam        = $this->input->post('jam');
            $desc       = $this->input->post('desc');
            $format     = $this->input->post('format');
            $status     = $this->input->post('status');

            $waktu = $tanggal . " " . $jam;
            $iWaktu = new DateTimeImmutable($waktu);
            $inputDate = $iWaktu->format('U');

            $now = $inputDate; // mengambil Unix timestamp saat ini
            $plus_48_hours = strtotime('+48 hours', $now); // menambahkan 48 jam ke timestamp saat ini

            $urutan = $this->m_followup->getUrutan($format);
            foreach ($urutan->result() as $np) {
                $idpo   = $np->idArr;
                $urutan = $idpo;
                $urutan = $idpo + 1;
                $code   = date('ymd') . "/" . $kategori . "-" . sprintf("%04s", $urutan);
                // 230313/CWA-0001
            }

            $data = [
                'followup_id'   => $code,
                'customer_name' => $nmcustomer,
                'id_category'   => $kategori,
                'pic'           => $pic,
                'phone' => $kontak,
                'add_by' => $this->session->userdata('nama_lengkap'),
                'date' => $inputDate,
                'description' => $desc,
                'format_customer' => $format,
                'status' => $status
            ];

            $this->db->insert('tb_followup', $data);

            $data_2 = [
                'followup_id'   => $code,
                'followup_date' => $inputDate,
                'comment'       => '0',
                'notes'         => $desc,
                'input_date'    => time(),
                'due_date'      => $plus_48_hours
            ];

            $this->db->insert('tb_followup_detail', $data_2);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation!,Customer Folllowup Baru ditambahkan!</div>');
            redirect('followup/liste');
        }
    }

    public function cstCategory()
    {

        $this->form_validation->set_rules('name', 'Nama', 'trim|required|is_unique[tb_category.nama]', [
            'required' => 'Nama wajib diisi',
            'is_unique' => 'Kategori ini sudah ada'
        ]);
        $this->form_validation->set_rules('code', 'Kode', 'trim|required|max_length[3]|min_length[3]|is_unique[tb_category.kode]', [
            'required' => 'Kode wajib diisi',
            'max_length' => 'Kode Max 3 karakter',
            'min_length' => 'Kode Min 3 karakter',
            'is_unique' => 'Kode ini sudah ada, harap ganti'
        ]);

        if ($this->form_validation->run() == FALSE) {
            # code...
            $data['title'] = 'Kategori Customer';
            $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/headbar', $data);
            $this->load->view('followup/kategori-customer', $data);
            $this->load->view('templates/footer');
        } else {
            # code...
            $data = [
                'nama' => $this->input->post('name'),
                'kode' => $this->input->post('code'),
                'bagian'    => $this->session->userdata('role_id')
            ];

            $this->db->insert('tb_category', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">kategori sudah ditambahkan</div>');
            redirect('followup/cstCategory');
        }
    }

     public function getCategory()
    {
        if ($this->session->userdata('role_id') == '1') {
            $ctr = $this->db->get('tb_category');
            $data = array();
            foreach ($ctr->result() as $c) {
                $data[] = array(
                    'name'  => $c->nama,
                    'kode'  => $c->kode,
                    'bagian' => $c->bagian
                );
            }
        } else {
            $ctr = $this->db->get_where('tb_category', ['bagian' => $this->session->userdata('role_id')]);
            $data = array();
            foreach ($ctr->result() as $c) {
                $data[] = array(
                    'name'  => $c->nama,
                    'kode'  => $c->kode,
                    'bagian' => $c->bagian
                );
            }
        }
        
        echo json_encode($data);
    }


    public function newFollowup($id)
    {
        $key = "sifupass";
        $decryptedData = decryptData($id, $key);

        $data['title']      = 'Detail Followup';
        $data['user']       = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $data['follows']    = $this->db->get_where('tb_followup', ['followup_id' => $decryptedData])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('followup/detail-followup', $data);
        $this->load->view('templates/footer');
    }

    public function savehasilFu()
    {
        $tanggal    = date_format(date_create($this->input->post('tanggal')), "Y-m-d");
        $jam        = $this->input->post('jam');

        $waktu = $tanggal . " " . $jam;
        $iWaktu = new DateTimeImmutable($waktu);
        $inputDate = $iWaktu->format('U');

        $now = $inputDate; // mengambil Unix timestamp saat ini
        $plus_48_hours = strtotime('+48 hours', $now); // menambahkan 48 jam ke timestamp saat ini

        $idf = $this->input->post('idfollowup');
        $data = [
            'followup_id' => $this->input->post('idfollowup'),
            'followup_date' => $inputDate,
            'comment'   => $this->input->post('kategori'),
            'notes' => $this->input->post('note'),
            'input_date' => time(),
            'due_date' => $plus_48_hours
        ];

        $this->db->insert('tb_followup_detail', $data);

        $isactive = $this->input->post('isactive');
        if ($isactive) { //close project
            $this->db->set('is_open', '0');
            $this->db->where('followup_id', $idf);

            $this->db->update('tb_followup');
        }
        
        $this->db->set('date', $inputDate);
        $this->db->where('followup_id', $idf);
        $this->db->update('tb_followup');

        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Berhasil simpan data barus</div>');
        redirect('followup/liste');
    }

    public function detailFu()
    {
        $id = $this->input->post('id');

        $data['title'] = 'Detail Followup';
        $data['user'] = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/headbar', $data);
        $this->load->view('followup/list-detail-fu', $data);
        $this->load->view('templates/footer');
    }

    public function getDetailCustomer()
    {
        $nama = $this->session->userdata('nama_lengkap');
        $role_id = $this->session->userdata('role_id');

        $customer = $this->m_followup->getDetailCustomer($nama, $role_id);
        $data = array();
        $no = 1;
        foreach ($customer->result() as $row) {
            $data[] = array(
                'no' => $no++,
                'followup_id' => $row->followup_id,
                'customer_name' => $row->customer_name,
                'comment' => $row->comment,
                'followup_date' => date("Y-m-d H:i", $row->followup_date),
                'due_date' => date("Y-m-d H:i", $row->due_date),
                'status' => $row->status,
                'is_open' => $row->is_open,
                'add_by' => $row->add_by
            );
        }
        echo json_encode($data);
    }

    public function viewDetail()
    {
        $id = $this->input->post('id');

        $row = $this->db->get_where('tb_followup', ['followup_id' => $id])->result_array();
        $row_dua = $this->db->get_where('tb_followup_detail', ['followup_id' => $id]);
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
                                    <th>PIC</th>
                                    <td>:</td>
                                    <td>' . $r['pic'] . '</td>
                                </tr>
                                <tr>
                                    <th>Kontak</th>
                                    <td>:</td>
                                    <td>' . $r['phone'] . '</td>
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
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <table class="table" width="100%">
                            <thead>
                                <th>Comment</th>
                                <th>Tanggal Followup</th>
                                <th>Due-date</th>
                                <th>Note</th>
                            </thead>
                            <tbody>';
                                foreach($row_dua->result() AS $rw) {
                                    if(($rw->comment == '0')) {
                                        $info = '<span class="label label-danger"><i class="fa fa-phone-square"></i> Kontak</span>';
                                    } elseif(($rw->comment == '1')) {
                                        $info = '<span class="label label-warning"><i class="fa fa-question-circle"></i> Followup</span>';
                                    } elseif(($rw->comment == '2')){
                                        $info = '<span class="label label-success"><i class="fa fa-file"></i> Penawaran</span>';
                                    } elseif(($rw->comment == '3')){
                                        $info = '<span class="label label-primary"><i class="fa fa-question-circle"> Followup Penawaran</span>';
                                    } elseif(($rw->comment == '4')){
                                        $info = '<span class="label label-info"><i class="fa fa-shopping-cart"> Sudah PO/ Order</span>';
                                    }
                                    $html .='<tr>
                                        <td>' . $info .'</td>
                                        <td>' . date("d-m-Y H:i", $rw->followup_date) .'</td>
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
}
