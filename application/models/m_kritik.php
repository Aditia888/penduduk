<?php
class M_kritik extends CI_Model
{
    public function getByWarga($idWarga)
    {
        return $this->db->where('id_warga', $idWarga)
            ->order_by('created_at', 'DESC')
            ->get('kritik_saran')
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert('kritik_saran', $data);
    }

    public function getAll()
    {
        return $this->db
            ->select('k.*, dw.nama')
            ->from('kritik_saran k')
            ->join('data_warga dw', 'dw.idWarga = k.id_warga')
            ->order_by('k.created_at', 'DESC')
            ->get()
            ->result();
    }
}
