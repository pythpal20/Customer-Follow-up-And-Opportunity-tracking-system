<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->form_validation->set_rules('namauser', 'Nama User', 'trim|required');
        $this->form_validation->set_rules('email', 'E-Mail', 'required|trim|valid_email|is_unique[tb_user.email]', [
            'valid_email'   => 'Format penulisan email salah!',
            'is_unique'     => 'Email ini sudah terdaftar'
        ]);
        $this->form_validation->set_rules('role', 'Role Access', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|required|trim|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');


        if ($this->form_validation->run() == FALSE) {
            $data['title']  = 'Daftar Pengguna';
            $data['user']   = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
            $data['rolex']  = $this->db->get('user_role');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/headbar', $data);
            $this->load->view('user/listuser', $data);
            $this->load->view('templates/footer');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            // var_dump($this->input->post());
            $this->load->model("m_user");
            $dtx = $this->m_user->urutanUser();

            foreach ($dtx->result() as $d) {
                $nomor  = $d->idUser;
                $urut   = $nomor + 1;
                $idUser = "MK-" .  sprintf("%03s", $urut);
            }
            // var_dump($dtx); die();

            $id_user    = $idUser;
            $nama       = $this->input->post('namauser');
            $email      = $this->input->post('email');
            $role       = $this->input->post('role');
            $password   = $this->input->post('password');

            $data  = [
                'user_id'       => htmlspecialchars($id_user),
                'user_nama'     => htmlspecialchars($nama),
                'email'         => htmlspecialchars($email),
                'password'      => password_hash($password, PASSWORD_DEFAULT),
                'role_id'       => htmlspecialchars($role),
                'is_active'     => "1",
                'create_date'  => time()
            ];

            $this->db->insert('tb_user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User baru ditambahkan!</div>');
            redirect('user');
        }
    }

    public function dataUser()
    {
        $this->load->model("m_user");
        $user = $this->m_user->allUser();
        $data = array();
        $no = 1;

        foreach ($user->result() as $r) {
            if($r->is_active != 0) {
                $data[] = array(
                    'id'    => $r->user_id,
                    'no'    => $no++,
                    'nama'  => $r->user_nama,
                    'role'  => $r->role,
                    'role_id'   => $r->role_id,
                    'aktif'     => $r->is_active,
                    'email'     => $r->email,
                    'nominal'   => "Rp. " . number_format(sumPo($r->user_nama, date('m')), 0, ",", ".")
                );
            }
        }

        print_r(json_encode($data));
    }

    public function dtlUser()
    {
        $id = $this->input->post('id');

        $this->load->model("m_user");
        $user   = $this->m_user->getUserdetail($id);

        $output = '';
        foreach($user->result() as $u) {
            $output .='
            <table class="table table-borderless table-striped" width="100%">
                <tr>
                    <th width="35%">Nama User</th>
                    <td>:</td>
                    <th width="35%">' . $u->user_nama . '</th>
                    <td rowspan="4"><img alt="image" class="img-fluid" src="' . base_url("assets/img/gallery/") . $u->photo . '"></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>:</td>
                    <th>' . $u->email . '</th>
                </tr>
                <tr>
                    <th>Role Access</th>
                    <td>:</td>
                    <th>' . $u->role . '</th>
                </tr>
                <tr>
                    <th>Tgl Akun</th>
                    <td>:</td>
                    <th>' . date('d/m/Y H:i',$u->create_date) . '</th>
                </tr>
            </table>';
        }
        echo $output;
    }
    
    public function nonaktifUser()
    {
        $id = $this->input->post('id');
        
        $this->db->set('is_active', '0');
        $this->db->where('user_id', $id);
        $this->db->update('tb_user');
    }
    
    public function editUser($id)
    {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|required|trim|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('nama', 'Nama User', 'trim|required');
        $this->form_validation->set_rules('email', 'E-Mail', 'required|trim|valid_email', [
            'valid_email'   => 'Format penulisan email salah!'
        ]);
        
        
        if ($this->form_validation->run() == FALSE) {
            $data['title']  = 'Daftar Pengguna';
            $data['user']   = $this->db->get_where('tb_user', ['email' => $this->session->userdata('email')])->row_array();
            $data['rolex']  = $this->db->get('user_role');
            
            $key = "sifupass";
            $decryptedData = decryptData($id, $key);
            
            $data['euser']  = $this->db->get_where('tb_user', ['user_id' => $decryptedData])->row_array();
            $data['id'] = set_value('id', $id);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/headbar', $data);
            $this->load->view('user/editUser', $data);
            $this->load->view('templates/footer');
        } else {
            $nama   = $this->input->post('nama');
            $code   = $this->input->post('code');
            $email  = $this->input->post('email');
            $password   = $this->input->post('password');
            
            $file_name  = $_FILES['images']['name'];
            $ext        = "." . explode(".", $file_name)[1];
            $newName    = $code . $ext;
            
            $config['upload_path']      = './assets/img/gallery/';
            $config['allowed_types']    = 'jpg|JPG|jpeg|png';
            $config['file_name']        = $newName;
            $config['overwrite']        = true;
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('images')) {
                $data  = [
                    'user_nama'     => htmlspecialchars($nama),
                    'email'         => htmlspecialchars($email),
                    'password'      => password_hash($password, PASSWORD_DEFAULT),
                    'photo'         => $newName
                ];
                
                $this->db->where('user_id', $code);
                $this->db->update('tb_user', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update berhasil!</div>');
                redirect('user');
            } else {
                echo $this->upload->display_errors();
            }
        }
    }
}