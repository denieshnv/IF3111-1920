<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Laporan extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('laporan_model');
            $this->load->helper('url_helper');
        }

        public function input(){
            $isi = $this->input->post('kolomlaporan');
            $aspek = $this->input->post('dropdownbuat');
            $lampiran =$_FILES['namalampiran']['name'];

            if($lampiran = ''){

            } else {
                $config['upload_path']      = './lampiran/';
                $config['allowed_types']    = 'jpg|png|gif';
                $config['file_name']        = date('Y-m-d H-i-s', time());
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('namalampiran')) {
                    echo "upload gagal"; die();
                } else {
                    $lampiran = $this->upload->data('file_name');
                }
                $data = array(
                    'isi_laporan'=> $isi,
                    'aspek'     => $aspek,
                    'lampiran' => $lampiran
                );
            
                $this->laporan_model->input_laporan(laporan,$data);
            redirect('');
        }
    }

        public function delete($id){
            $where = array('id_laporan' => $id);
            $this->laporan_model->hapus_laporan($where, 'laporan');
            redirect('template');
        }

        public function edit($id){
            $data=array(
                "id_laporan"=>$id
            );
            $hasil['komentar']=$this->laporan_model->get_laporan1($data)->result();
            $this->load->view('default/header');
            $this->load->view('konten/edit',$hasil);
        
        }
        
        public function view($id) {
            $data['laporan'] = $this->laporan_model->get_laporan($id);
            $this->load->view('default/header');
            $this->load->view('konten/detail_laporan', $data);
        }
        
        public function search(){
            $keyword =$this->input->get('keyword');
            $data['result']=$this->laporan_model->search_data($keyword,'laporan');
            $this->load->view('default/header');
            $this->load->view('search_result',$data);
        }

        public function update($id){
            $isi = $this->input->post('kolomlaporan');
            $aspek = $this->input->post('dropdownbuat');
            $lampiran =$_FILES['namalampiran']['name'];

            if($lampiran = ''){

            } else {
                $config['upload_path']      = './lampiran/';
                $config['allowed_types']    = 'jpg|png|gif';
                $config['file_name']        = date('Y-m-d H-i-s', time());
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('namalampiran')) {
                    echo "upload gagal"; die();
                } else {
                    $lampiran = $this->upload->data('file_name');
                }
                $data = array(
                    'isi_laporan'=> $isi,
                    'aspek'     => $aspek,
                    'lampiran' => $lampiran
                );
                $index = array(
                    "id_laporan"=>$id
                );
                $this->laporan_model->update($index,$data,"laporan");

            redirect('');
        }
    }}