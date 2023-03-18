<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_master');
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

    function getsummaryFollowup()
    {
        $summary_data = $this->m_master->getSumfu();
        $data = array();

        foreach ($summary_data->result() as $r) {
            $data[] = array(
                'user'              => $r->add_by,
                'kontak'            => $r->kontak,
                'followup'          => $r->followup,
                'penawaran'         => $r->penawaran,
                'followup_penawaran' => $r->followup_penawaran,
                'order'             => $r->orders
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
}
