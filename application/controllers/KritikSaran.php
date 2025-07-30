<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KritikSaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kritik');
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $username = $this->session->userdata('username');
        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        // if (!$user || in_array($user['role_id'], [1, 5])) {
        //     show_error('Anda tidak memiliki akses ke halaman ini.');
        // }

        if (!isset($user['idWarga'])) {
            show_error('Akun Anda belum terhubung ke data warga. Hubungi admin.');
        }

        $data['menu'] = 'kritik_saran';
        $data['judul'] = 'Kritik dan Saran';
        $data['user'] = $user;
        $data['list_kritik'] = $this->M_kritik->getByWarga($user['idWarga']);

        $this->load->view('include/header_warga', $data);
        $this->load->view('warga/kritik_saran', $data);
        $this->load->view('include/footer');
    }

    public function kirim()
    {
        $username = $this->session->userdata('username');
        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        if (!$user || in_array($user['role_id'], [1, 5])) {
            show_error('Akses ditolak.');
        }

        if (!isset($user['idWarga'])) {
            show_error('Akun Anda belum terhubung ke data warga. Hubungi admin.');
        }

        $isi = $this->input->post('isi', TRUE);

        if (empty($isi)) {
            $this->session->set_flashdata('error', 'Isi kritik/saran tidak boleh kosong.');
            redirect('kritikSaran');
        }

        $data = [
            'id_warga' => $user['idWarga'],
            'isi' => $isi,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->M_kritik->insert($data);
        $this->session->set_flashdata('success', 'Kritik/Saran berhasil dikirim.');
        redirect('kritikSaran');
    }

    public function rt()
    {
        $username = $this->session->userdata('username');
        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        if (!$user || $user['role_id'] != 1) {
            show_error('Halaman ini hanya untuk Ketua RT.');
        }

        $data['menu'] = 'kritik_saran_rt';
        $data['judul'] = 'Kritik & Saran dari Seluruh Warga';
        $data['user'] = $user;
        $data['list_kritik'] = $this->M_kritik->getAll();

        $this->load->view('include/header', $data);
        $this->load->view('rt/kritik_saran', $data);
        $this->load->view('include/footer');
    }
}
