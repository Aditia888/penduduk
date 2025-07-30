<?php

/**
 * @property CI_DB_query_builder $db
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property M_kas $M_kas
 */
class Kas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kas');
        if (!$this->session->userdata('username')) redirect('auth');
    }

    public function index()
    {
        $tahun = $this->input->get('tahun');
        if (!$tahun) $tahun = date('Y'); // default tahun sekarang

        $user = $this->db->get_where('users', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        // if ($user['role_id'] != 4) show_error("Hanya untuk warga");

        $idWarga = $user['idWarga'];

        $data['judul'] = "Pembayaran Kas & Sampah";
        $data['menu'] = "kas";
        $data['user'] = $user;
        $data['tahun'] = $tahun;
        $data['kas'] = $this->M_kas->getPembayaranBulanan($idWarga, $tahun, 'kas');
        $data['sampah'] = $this->M_kas->getPembayaranBulanan($idWarga, $tahun, 'sampah');

        $this->load->view('include/header_warga', $data);
        $this->load->view('warga/kas', $data);
        $this->load->view('include/footer');
    }

    public function upload()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');

        $user = $this->db->get_where('users', [
            'username' => $this->session->userdata('username')
        ])->row_array();

        $idWarga = $user['idWarga'];

        $config['upload_path'] = './uploads/bukti_pembayaran/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            $file = $this->upload->data('file_name');
            if ($status == 'kas') $cekId = $this->M_kas->cekNomor();
            else $cekId = $this->M_kas->cekNomorSampah();

            $getId = substr($cekId, 4, 4);
            $idNow = (int)$getId + 1;
            $kodePrefix = $status == 'kas' ? '3000' : '4000';
            $idKas = $kodePrefix . sprintf('%04s', $idNow);

            $data = [
                'idKas' => $idKas,
                'idWarga' => $idWarga,
                'keterangan' => 'Pembayaran ' . ucfirst($status) . ' Bulan ' . $bulan,
                'tanggal' => "$tahun-$bulan-01",
                'jumlah' => 50000,
                'jenis' => 'masuk',
                'status' => $status,
                'buktiPembayaran' => $file,
                'status_persetujuan' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('data_transaksi', $data);
            $this->session->set_flashdata('success', 'Bukti berhasil diupload.');
        }

        redirect('kas?tahun=' . $tahun);
    }
}
