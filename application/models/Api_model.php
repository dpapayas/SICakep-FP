<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

class Api_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function get_kontrak($tahun='',$jenis='',$kecamatan='',$tersedia='semua'){
		$this->db->select('kontrak as nama,
			CONCAT("Kontraktor : ",kontraktor,"\nNilai Kontrak : ",nilai_kontrak,"\nNomor : ",nomor_kontrak,"\nRealisasi : ",realisasi,satuan,"\nJangka Waktu Pengerjaan : ",waktu_pengerjaan," hari") as deskripsi,
			kontrak,kontraktor,nilai_kontrak,nomor_kontrak,realisasi,satuan,waktu_pengerjaan,latitude,longitude,
			kec.kecamatan,kel.kelurahan,
			JSON_OBJECT("nama", kontrak, "kontraktor", kontraktor, "nilai_kontrak", nilai_kontrak,
			"nomor",nomor_kontrak,"realisasi_output",CONCAT(realisasi,satuan),"tanggal_mulai",tgl_mulai,
			"tanggal_selesai",tgl_selesai,"jangka_waktu_pengerjaan",CONCAT(waktu_pengerjaan," hari"),
			"nilai_addendum",addendum,"jangka_waktu_pengerjaan",waktu_addendum,
			"realisasi_fisik",realisasi_fisik,"realisasi_keuangan",realisasi_uang,
			"nomor_BA_serah_terima_pekerjaan",nomor_ba,"tanggal_serah_terima_pekerjaan",tanggal_ba
		) as fullJson');
		$this->db->join('r_kecamatan kec', 'kec.kecamatan_id=d.kecamatan_id','left');
		$this->db->join('r_kelurahan kel', 'kel.kelurahan_id=d.kelurahan_id','left');
		if ($kecamatan!='') { 
			$this->db->where('LOWER(kec.kecamatan)', $kecamatan); 
		}
		if ($tersedia=='tersedia') {
			$this->db->where('nomor_kontrak IS NULL',null,false);
		} else if ($tersedia=='tidak') {
			$this->db->where('nomor_kontrak IS NOT NULL',null,false);
		}
		$this->db->where('tahun',$tahun);
		return $this->db->where('d.kontrak_jenis',$jenis)->get('d_kontrak_kerja d')->result_array();
	}

}