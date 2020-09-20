<?php

namespace App\Controllers;

class Pegawai extends BaseController
{
    public $pegawai_model;
    public $output = [
        'success'   => false,
        'message'   => '',
        'data'      => []
    ];

    public function __construct()
    {
        $this->pegawai_model = new \App\Models\M_Pegawai();
    }

    public function index()
    {
        return view('pegawai_view');
    }

    public function ajax_list()
    {
        $pegawai_model = $this->pegawai_model;
        $where = ['pegawai_id !=' => 0];
        $column_order   = array('', '', 'nip', 'nama_pegawai', 'alamat');
        $column_search  = array('nip', 'nama_pegawai', 'alamat');
        $order = array('nip' => 'ASC');
        $list = $pegawai_model->get_datatables('pegawai', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $view = '<a href="#" onclick="view_record(' . $lists->pegawai_id . ') "title="View"><span style="font-size: 1em; color: Mediumslateblue;"><i class="fa fa-eye"></i></span></a>';
            $edit = '<a href="#" onclick="edit_record(' . $lists->pegawai_id . ') "title="Edit"><span style="font-size: 1em; color: Dodgerblue;"><i class="fa fa-edit"></i></span></a>';
            $delete = '<a href="#" onclick="delete_record(' . $lists->pegawai_id . ') "title="Delete"><span style="font-size: 1em; color: Tomato;"><i class="fa fa-trash"></span></a>';
            $row[]  = $view.'&nbsp;&nbsp;'.$edit.'&nbsp;&nbsp;'.$delete;
            $row[]  = $no;
            $row[]  = $lists->nip;
            $row[]  = $lists->nama_pegawai;
            $row[]  = $lists->alamat;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $pegawai_model->count_all('pegawai', $where),
            "recordsFiltered" => $pegawai_model->count_filtered('pegawai', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function store()
    {
        $pegawai_model = $this->pegawai_model;
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();
            if (!$this->validate([
                'nip'           => 'required|min_length[5]|max_length[15]|is_unique[pegawai.nip]',
                'nama_pegawai'  => 'required',
                'alamat'        => 'required'
            ])){
                $this->output['errors'] = $validation->getErrors();
                echo json_encode($this->output);
            }else{
                $nip = $this->request->getPost('nip');
                $nama_pegawai = $this->request->getPost('nama_pegawai');
                $alamat = $this->request->getPost('alamat');
                $pegawai = [
                    'nip'           => $nip,
                    'nama_pegawai'  => $nama_pegawai,
                    'alamat'        => $alamat,
                ];
                $save = $pegawai_model->save($data);
                if ($save) {
                    $this->output['success'] = true;
                    $this->output['message'] = 'Record has been added successfully.';
                }
                echo json_encode($this->output);
            }
        }
    }    
    
    public function show($id)
    {
        $pegawai_model = $this->pegawai_model;
        if ($this->request->isAJAX()) {
            $result = $pegawai_model->find($id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
            }
            echo json_encode($this->output);
        }
    }    
    
    public function edit()
    {
        $pegawai_model = $this->pegawai_model;
        if ($this->request->isAJAX()) {
            $pegawai_id = $this->request->getVar('pegawai_id');
            $result = $pegawai_model->find($pegawai_id);
            if ($result) {
                $this->output['success'] = true;
                $this->output['message']  = 'Data ditemukan';
                $this->output['data']   = $result;
            }
            echo json_encode($this->output);
        }
    }    

    public function update()
    {
        $pegawai_model = $this->pegawai_model;
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();
            if (!$this->validate([
                'nip'           => 'required|min_length[5]|max_length[15]|is_unique[pegawai.nip,pegawai_id,{pegawai_id}]',
                'nama_pegawai'  => 'required',
                'alamat'        => 'required'
            ])){
                $this->output['errors'] = $validation->getErrors();
                echo json_encode($this->output);
            }else{
                $data = [
                    'nip'           => $this->request->getVar('nip'),
                    'nama_pegawai'  => $this->request->getVar('nama_pegawai'),
                    'alamat'        => $this->request->getVar('alamat')
                ];
                $pegawai_id = $this->request->getVar('pegawai_id');
                $update = $pegawai_model->update($pegawai_id, $data);
                if ($update) {
                    $this->output['success'] = true;
                    $this->output['message']  = 'Record has been updated successfully';
                }
                echo json_encode($this->output);
            }
        }
    }    

    public function destroy()
    {
        $pegawai_model = $this->pegawai_model;
        if ($this->request->isAJAX()) {
            $pegawai_id = $this->request->getVar('pegawai_id');
            $delete = $pegawai_model->delete($pegawai_id);
            if ($delete) {
                $this->output['success'] = true;
                $this->output['message']  = 'Record has been removed successfully.';
            }
            echo json_encode($this->output);
        }
    }
	
}
