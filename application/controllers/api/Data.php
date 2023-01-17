<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Data extends REST_Controller {
	private $select = [
		['jalan as name,jalan,panjang','jembatan as name,jembatan,jalan as jalan_jembatan','ruas as name,ruas,luas'],
		['saluran as name,panjang','lokasi as name,lokasi,tahun_anggaran','irigasi as name,irigasi,panjang'],
		['no as name,no,jalan as jalan_pju,kelurahan,kecamatan,lampu'],
		['ipal as name,ipal,tahun_berdiri,alamat','hippam as name,hippam,alamat','gedung as name,gedung,alamat','bangunan as name,bangunan,alamat','kawasan as name,kawasan,periode'],
		['iplt as name,iplt,alamat,kapasitas','alamat as name,alamat,rt,rw','alamat as name,alamat,rt,rw'],
		['nama as name,nama,alamat','nama as name,nama,alamat','nama as name,alamat,rt,rw'],
		['lokasi as name,lokasi,alamat'],
		['kelurahan as name,jumlah,bangunan']
	];

	private $jenis = [
		['Prasarana Jalan','Jembatan','Leger Jalan'],
		['Drainase','Genangan Air','Irigasi'],
		['Penerangan Jalan Umum'],
		['IPAL','HIPPAM','Gedung','SLF','RTBL'],
		['IPLT','Tengki Septic','LLTT'],
		['RTLH','Bantuan PSU','Kawasan Kumuh'],
		['Rusunawa'],
		['KRK']
	];

	private $tables = [
		['d_jalan','d_jembatan','d_leger'],
		['d_drainase','d_genangan','d_irigasi'],
		['d_pju'],
		['d_ipal','d_hippam','d_gedung','d_slf','d_rtbl'],
		['d_iplt','d_tangki','d_lltt'],
		['d_rtlh','d_psu','d_kawasan_kumuh'],
		['d_rusunawa'],
		['d_krk']
	];

	function __construct() {
		parent::__construct();
	}

	function index_post(){
		$tahun = $this->input->post('tahun');
		$status_kontrak = $this->input->post('status_kontrak');
		$jenis1 = $this->input->post('jenis1[]');
		$jenis2 = $this->input->post('jenis2[]');
		$jenis1 = $jenis1 ? $jenis1 : [];
		$jenis2 = $jenis2 ? $jenis2 : [];

		$result = [];

		if ($jenis1) { 
			$this->db->select('kontrak as name,kontrak_jenis,kontrak,kontraktor,nilai_kontrak,nomor_kontrak,CONCAT(realisasi," ",satuan) as realisasi,concat(waktu_pengerjaan, " hari") as waktu_pengerjaan,waktu_pengerjaan as waktu,latitude,longitude,"kontrak" as kontrak');
			$this->db->where_in('kontrak_jenis',$jenis1);
			if ($tahun!='') {
				$this->db->where('tahun',$tahun);
			}
			if ($status_kontrak=='tersedia') {
				$this->db->where('nomor_kontrak IS NULL',null,false);
			} else if ($status_kontrak=='tidak') {
				$this->db->where('nomor_kontrak IS NOT NULL',null,false);
			}
			$tmp = $this->db->get('d_kontrak_kerja')->result();
			$result = array_merge($result,$tmp);
		}

		foreach ($jenis2 as $key => $i) {
			if (in_array($i, ['0_0','0_1','0_2','1_0','1_1','1_2','2_0','3_0','3_1','3_2','3_3','3_4','4_0','4_1','4_2','5_0','5_1','6_0','7_0'])) {
				$j = explode('_', $i);
				$a = $j[0];
				$b = $j[1];

				$select = $this->select[$a][$b];
				$jenis 	= $this->jenis[$a][$b];
				$table 	= $this->tables[$a][$b];

				$longitude 	= (in_array($a, ['7']) && in_array($b, ['0'])) ? '999 as longitude' : 'longitude';
				$latitude 	= (in_array($a, ['7']) && in_array($b, ['0'])) ? '999 as latitude' : 'latitude';

				$longitude 	= (in_array($a, ['1']) && in_array($b, ['0'])) ? '0 as longitude' : $longitude;
				$latitude 	= (in_array($a, ['1']) && in_array($b, ['0'])) ? '0 as latitude' : $latitude;

				$this->db->select($select.','.$longitude.','.$latitude.',"'.$jenis.'" as jenis, "'.$i.'" as capaian');
				$this->db->where('tahun',$tahun);
				$tmp = $this->db->get($table)->result();
				$result = array_merge($result, $tmp);
			}
		}

		$this->response($result, 200);

	}
}