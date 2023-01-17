<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class App extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Api_model','apimodel');
	}

	function get_data_get() {
		$kecamatan = $this->get('kecamatan');
		$pemilik = $this->get('pemilik');
		$jenis = $this->get('jenis');
		$kontrak = $this->get('kontrak');
		$tahun = $this->get('tahun');
		$tersedia = $this->get('tersedia');

		$status = 200;
		$message = 'Data Tidak Ditemukan';
		$is_coordinate = false;
		$result = [];
		if (in_array($kontrak, ['0','1','2','3','4','5','6'])) {
			$jenis_kontrak = '';
			if ($kontrak=='0') {
				$kontrak = 'PKP';
			} elseif ($kontrak=='1') {
				$kontrak = 'PBL';
			} elseif ($kontrak=='2') {
				$kontrak = 'PALD';
			} elseif ($kontrak=='3') {
				$kontrak = 'DRAINASE';
			} elseif ($kontrak=='4') {
				$kontrak = 'JALAN';
			} elseif ($kontrak=='5') {
				$kontrak = 'PJ';
			} elseif ($kontrak=='6') {
				$kontrak = 'RUSUNAWA';
			}
			$result = $this->apimodel->get_kontrak($tahun,$kontrak, $kecamatan, $tersedia);
		} else {
			$result = $this->get_records($tahun,$kecamatan,$pemilik, $jenis);
		}

		if (count($result)>0) {
			$status = 200;
			$message = count($result). ' Data Ditemukan';
			$is_coordinate = $this->_contain_coordinates($pemilik, $jenis);
		}

		$this->response([
			'status'=> $status,
			'message'=> $message,
			'data'=> $result,
			'is_coordinate'=> $is_coordinate,
		], $status);
	}



	function get_records($tahun='',$kecamatan='',$pemilik='-1', $jenis='-1'){
		if ($pemilik=='-1' and $jenis=='-1') {
			return [];
		}

		if ($pemilik=='0') {
			if ($jenis=='0') {
				$this->db->select('jalan as nama,concat("Panjang : ",panjang," km") as deskripsi,"" as longitude,"" as latitude,
					JSON_OBJECT("nama", jalan, "data_tahun", tahun, "panjang_ruas", concat(panjang," km"), 
					"kondisi_baik", concat(baik_km," km (",baik_persen, "%)"),
					"kondisi_sedang", concat(sedang_km," km (",sedang_persen, "%)"),
					"kondisi_rusak_ringan", concat(rusak_ringan_km," km (",rusak_ringan_persen, "%)"),
					"kondisi_rusak_berat", concat(rusak_berat_km," km (",rusak_berat_persen, "%)")
				)as fullJson');
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_jalan')->result();
			} else if ($jenis=='1') {
				$this->db->select('jembatan as nama,concat("Nama Jalan : ",jalan) as deskripsi,longitude,latitude,
					JSON_OBJECT("nama",jembatan,"nama_jalan",jalan,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"jenis",jenis,"material",material,"kondisi",kondisi,"dimensi (p*l*t)",concat(panjang," x ",lebar, " x ", tinggi),"tahun_pembuatan",tahun,"latitude",latitude,"longitude",longitude) as fullJson
					');
				$this->db->join('r_kondisi', 'r_kondisi.kondisi_id=d.kondisi_id','left');
				$this->db->join('r_jembatan_jenis', 'r_jembatan_jenis.jenis_id=d.jenis_id','left');
				$this->db->join('r_jembatan_material', 'r_jembatan_material.material_id=d.material_id','left');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id','left');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id','left');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_jembatan d')->result();
			} else if ($jenis=='2') {
				$this->db->select('ruas as nama,concat("Luas Rumija : ",luas) as deskripsi,"" as longitude,"" as latitude,
					JSON_OBJECT("nama_ruas", ruas, "luas_rumija", luas, "njop_2001",njop_2001,"njop_2019",njop_2019,"tahun",tahun) as fullJson
					');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_leger d')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='1') {
			if ($jenis=='0') {
				$this->db->select('saluran as nama,concat("Tipe/Panjang : ",drainase_tipe," ",d_drainase.panjang, "m") as deskripsi,"" as longitude, "" as latitude,JSON_OBJECT("coordinates",GROUP_CONCAT(latitude,"_",longitude)) as line,
					JSON_OBJECT("no id",d_drainase.no_id,"saluran",saluran,"kode",d_drainase.kode,"panjang",panjang,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"tipe",drainase_tipe,"panjang",panjang,"kondisi",kondisi,"tahun",tahun) as fullJson
					');
				$this->db->join('r_drainase_tipe', 'r_drainase_tipe.drainase_tipe_id=d_drainase.drainase_tipe_id');
				$this->db->join('d_drainase_lines', 'd_drainase_lines.drainase_id=d_drainase.drainase_id','left');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d_drainase.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d_drainase.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				$this->db->group_by('d_drainase.no_id');
				return $this->db->get('d_drainase')->result();
			} else if ($jenis=='1') {
				$this->db->select('lokasi as nama,concat("Tahun Anggaran : ",tahun_anggaran) as deskripsi,"" as longitude,"" as latitude,
					JSON_OBJECT("lokasi",lokasi,"tahun",tahun) as fullJson
					');
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_genangan')->result();
			} else if ($jenis=='2') {
				$this->db->select('irigasi as nama,concat("Panjang: ",panjang,"m") as deskripsi,longitude,latitude, JSON_OBJECT("nama_daerah",irigasi,"panjang",panjang,"jenis_irigasi",irigasi_jenis,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"tahun",tahun,"latitude",latitude,"longitude",longitude) as fullJson
					');
				$this->db->join('r_irigasi_jenis', 'r_irigasi_jenis.irigasi_jenis_id=d_irigasi.irigasi_jenis_id');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d_irigasi.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d_irigasi.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_irigasi')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='2') {
			if ($jenis=='0') {
				$this->db->select('jalan as nama,concat("Tiang: ",pju_tiang) as deskripsi,longitude,latitude, JSON_OBJECT("no",no,"latitude",latitude,"longitude",longitude,"jalan",jalan,"kecamatan",r_kecamatan.kecamatan,"kelurahan",r_kelurahan.kelurahan,"tiang",pju_tiang,"jaringan",pju_jaringan,"jumlah_lampu",lampu,"jenis_lampu",pju_lampu,"daya",daya,"status",status,"kondisi",kondisi,"kelompok",pju_kelompok,"kapasitas_va",va,"kapasitas_kwh",kwh,"rpj",rpj) as fullJson
					');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_pju d')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='3') {
			if ($jenis=='0') {
				$this->db->select('ipal as nama,concat("Alamat: ",alamat) as deskripsi,"" as longitude,"" as latitude, 
					JSON_OBJECT("ipa",ipal,"jenis",ipal_jenis,"alamat",alamat,"kelurahan",r_kelurahan.kelurahan,"kecamatan",r_kecamatan.kecamatan,"tahun_berdiri",tahun_berdiri,"kapasitas",kapasitas,"pemanfaatan",pemanfaatan,"pemakai",pemakai,"tahun",tahun) as fullJson
					');
				$this->db->join('r_ipal_jenis', 'r_ipal_jenis.ipal_jenis_id=d_ipal.ipal_jenis_id');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d_ipal.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d_ipal.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_ipal')->result();
			} else if ($jenis=='1') {
				$this->db->select('hippam as nama,concat("Alamat: ",alamat) as deskripsi,"" as longitude,"" as latitude, JSON_OBJECT("hippam",hippam,"alamat",alamat,"kecamatan",kecamatan,"latitude",latitude,"longitude",longitude,"tahun_pembangunan",tahun_bangun,"kapasitas_sumber",kapasitas_sumber,"kapaistas_pasang",kapasitas_pasang,"pelanggan",pelanggan,"pelayanan",pelayanan,"kontrak",kontrak) as fullJson
					');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_hippam d')->result();
			} else if ($jenis=='2') {
				$this->db->select('gedung as nama,concat("Alamat: ",alamat) as deskripsi,longitude,latitude,JSON_OBJECT("nama_gedung",gedung,"alamat",alamat,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"status_lahan",lahan_status,"kondisi",gedung_kondisi,"tahun",tahun,"latitude",latitude,"longitude",longitude) as fullJson');
				$this->db->join('r_gedung_kondisi', 'r_gedung_kondisi.gedung_kondisi_id=d.gedung_kondisi_id');
				$this->db->join('r_lahan_status', 'r_lahan_status.lahan_status_id=d.lahan_status_id');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_gedung d')->result();
			} else if ($jenis=='3') {
				$this->db->select('bangunan as nama,concat("Alamat: ",alamat) as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("bangunan",bangunan,"alamat",alamat,"kecamatan",r_kecamatan.kecamatan,"status",slf_status,"tahun",tahun) as fullJson');
				$this->db->join('r_slf_status', 'r_slf_status.slf_status_id=d.slf_status_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_slf d')->result();
			} else if ($jenis=='4') {
				$this->db->select('kawasan as nama,"Titik Lokasi: -" as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("kawasan",kawasan,"kecamatan",r_kecamatan.kecamatan,"status",rtbl_status,"periode",periode,"tahun",tahun) as fullJson');
				$this->db->join('r_rtbl_status', 'r_rtbl_status.rtbl_status_id=d.rtbl_status_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_rtbl d')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='4') {
			if ($jenis=='0') {
				$this->db->select('iplt as nama,concat("Alamat: ",alamat) as deskripsi,longitude,latitude,JSON_OBJECT("iplt",iplt,"alamat",alamat,"kecamatan",r_kecamatan.kecamatan,"kelurahan",r_kelurahan.kelurahan,"kapasitas",kapasitas,"kondisi",iplt_kondisi,"tahun",tahun,"terpelihara",IF(is_terpelihara=1, "Iya", "Tidak"),"latitude",latitude,"longitude",longitude) as fullJson');
				$this->db->join('r_iplt_kondisi', 'r_iplt_kondisi.iplt_kondisi_id=d.iplt_kondisi_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_iplt d')->result();
			} else if ($jenis=='1') {
				return [];
			} else if ($jenis=='2') {
				$this->db->select('alamat as nama,concat("RT/RW: ",rt,"/",rw) as deskripsi,longitude,latitude,JSON_OBJECT("alamat",alamat,"RT/RW",concat(rt,"/",rw),"kecamatan",r_kecamatan.kecamatan,"kelurahan",r_kelurahan.kelurahan,"lebar_jalan",lltt_lebar,"jarak_dari_jalan",lltt_jarak,"pemakaian_air",pemakaian,"latitude",latitude,"longitude",longitude,"air_untuk_minum",lltt_minum,"air_untuk_masak",lltt_masak,"jenis_tangki_septik",lltt_tangki,"letak",lltt_letak,"akses_penyedotan",lltt_sedot) as fullJson');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				$this->db->join('r_lltt_lebar', 'r_lltt_lebar.lltt_lebar_id=d.lltt_lebar_id');
				$this->db->join('r_lltt_jarak', 'r_lltt_jarak.lltt_jarak_id=d.lltt_jarak_id');
				$this->db->join('r_lltt_minum', 'r_lltt_minum.lltt_minum_id=d.lltt_minum_id');
				$this->db->join('r_lltt_masak', 'r_lltt_masak.lltt_masak_id=d.lltt_masak_id');
				$this->db->join('r_lltt_tangki', 'r_lltt_tangki.lltt_tangki_id=d.lltt_tangki_id');
				$this->db->join('r_lltt_letak', 'r_lltt_letak.lltt_letak_id=d.lltt_letak_id');
				$this->db->join('r_lltt_sedot', 'r_lltt_sedot.lltt_sedot_id=d.lltt_sedot_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_tangki d')->result();
			} else if ($jenis=='3') {
				$this->db->select('alamat as nama,concat("RT/RW : ",rt,"/",rw) as deskripsi,longitude,latitude,JSON_OBJECT("alamat_bangunan",alamat,"RT/RW",concat(rt,"/",rw),"kelurahan",kelurahan,"kecamatan",r_kecamatan.kecamatan,"jenis_bangunan",lltt_jenis,"fungsi_bangunan",lltt_fungsi,"lebar_jalan_masuk",lltt_lebar,"jarak_dari_jalan_besar",lltt_jarak,"tahun_pembangunan",tahun_bangun,"luas_bangunan",luas,"jumlah_lantai",lantai,"jumlah_penghuni",penghuni,"jenis_tangki_septik",lltt_tangki,"letak_tangki_septik",lltt_letak,"Pelanggan",IF(is_pelanggan=1, "Iya", "Tidak"),"nomor_saluran",nosal,"terakhir_disedot",tahun_sedot) as fullJson');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id','left');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id','left');
				$this->db->join('r_lltt_jenis', 'r_lltt_jenis.lltt_jenis_id=d.lltt_jenis_id','left');
				$this->db->join('r_lltt_fungsi', 'r_lltt_fungsi.lltt_fungsi_id=d.lltt_fungsi_id','left');
				$this->db->join('r_lltt_lebar', 'r_lltt_lebar.lltt_lebar_id=d.lltt_lebar_id','left');
				$this->db->join('r_lltt_jarak', 'r_lltt_jarak.lltt_jarak_id=d.lltt_jarak_id','left');
				$this->db->join('r_lltt_tangki', 'r_lltt_tangki.lltt_tangki_id=d.lltt_tangki_id','left');
				$this->db->join('r_lltt_letak', 'r_lltt_letak.lltt_letak_id=d.lltt_letak_id','left');
				$this->db->join('r_lltt_sedot', 'r_lltt_sedot.lltt_sedot_id=d.lltt_sedot_id','left');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where_not_in('latitude', ['-']);
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_lltt d')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='5') {
			if ($jenis=='0') {
				$this->db->select('nama,concat("Alamat: ",alamat) as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("nama",nama,"alamat",alamat,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"tahun",tahun) as fullJson');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_rtlh d')->result();
			} else if ($jenis=='1') {
				$this->db->select('nama,concat("Alamat: ",alamat) as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("nama",nama,"alamat",alamat,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"status",psu_status,"tahun",tahun) as fullJson');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				$this->db->join('r_psu_status', 'r_psu_status.psu_status_id=d.psu_status_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_psu d')->result();
			} else if ($jenis=='2') {
				return [];
			} else {
				return [];
			}
		} else if ($pemilik=='6') {
			if ($jenis=='0') {
				$this->db->select('lokasi as nama,concat("Alamat: ",alamat) as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("lokasi",lokasi,"alamat",alamat,"kecamatan",r_kecamatan.kecamatan,"kelurahan",kelurahan,"twin_blok",blok,"kapasitas",kapasitas,"kondisi",rusunawa_kondisi,"tahun",tahun) as fullJson');
				$this->db->join('r_kelurahan', 'r_kelurahan.kelurahan_id=d.kelurahan_id');
				$this->db->join('r_kecamatan', 'r_kecamatan.kecamatan_id=d.kecamatan_id');
				$this->db->join('r_rusunawa_kondisi', 'r_rusunawa_kondisi.rusunawa_kondisi_id=d.rusunawa_kondisi_id');
				if ($kecamatan!='') { 
					$this->db->where('LOWER(r_kecamatan.kecamatan)', $kecamatan); 
				}
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_rusunawa d')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='7') {
			if ($jenis=='0') {
				$this->db->select('kelurahan as nama,concat("Jumlah: ",jumlah) as deskripsi,"" as longitude,"" as latitude');
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_krk')->result();
			} else {
				return [];
			}
		} else if ($pemilik=='8') {
			if ($jenis=='0') {
				$this->db->select('nama,concat("Jenis: ",sewa_jenis) as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("nama",nama,"jenis_alat",sewa_jenis,"no_alat_berat",alat,"kapasitas",kapasitas,"mulai",mulai,"selesai",selesai,"lama",lama,"lokasi",lokasi,"keterangan",keterangan) as fullJson');
				$this->db->join('r_sewa_jenis', 'r_sewa_jenis.sewa_jenis_id=d.sewa_jenis_id');
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_sewa d')->result();
			} else if ($jenis=='1') {
				$this->db->select('lokasi as nama,concat("Jenis: ",lab_jenis) as deskripsi,"" as longitude,"" as latitude,JSON_OBJECT("lokasi",lokasi,"jenis",lab_jenis,"tahun",tahun) as fullJson');
				$this->db->join('r_lab_jenis', 'r_lab_jenis.lab_jenis_id=d.lab_jenis_id');
				$this->db->where('tahun',$tahun);
				return $this->db->get('d_lab d')->result();
			} else {
				return [];
			}
		} else {
			return [];
		}
	}

	function _contain_coordinates($pemilik='-1', $jenis='-1'){
		if ($pemilik=='-1' and $jenis=='-1') {
			return false;
		}

		if ($pemilik=='0') {
			if ($jenis=='1') { return true; }
			else { return false; }
		} else if ($pemilik=='1') {
			return true;
		} else if ($pemilik=='2') {
			return true;
		} else if ($pemilik=='3') {
			if ($jenis=='2') { return true; }
			else { return false; }
		} else if ($pemilik=='4') {
			if ($jenis=='1') { return false; }
			else { return true; }
		} else if ($pemilik=='5') {
			return false;
		} else if ($pemilik=='6') {
			return false;
		} else if ($pemilik=='7') {
			return false;
		} else if ($pemilik=='8') {
			return false;
		} else { return false; }


	}
}