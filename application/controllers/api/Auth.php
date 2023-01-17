<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Auth extends REST_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function login_get(){
		$username = $this->get('username');
		$password = $this->get('password');

		$result = (object)[];
		$message = '';
		$status = 203;
		$query = $this->db->query("	SELECT  HEX(u.user_id) as user_id, u.nama, u.is_aktif, u.password, HEX(g.group_id) as group_id, g.nama as gnama
			FROM  s_user u 
			JOIN  s_user_group ug ON u.user_id = ug.user_id
			JOIN  s_group g ON ug.group_id = g.group_id
			WHERE   u.username = ?", [$username]);
		if($query->num_rows() == 1){
			$query = $query->row();

			if($query->is_aktif){
				if(password_verify($password, $query->password)){
					$message = 'Login Berhasil';
					$result = $query;
					$status = 200;
				} else {
					$message = 'Username dan Password salah';
				}
			} else {
				$message = 'User tidak aktif.';
			}
		} else {
			$message = 'Username dan Password salah';
		}

		$this->response([
			'status'=> $status,
			'message'=> $message,
			'data'=> $result,
		], $status);
	}

	function login_post() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$result = (object)[];
		$message = '';
		$status = 203;
		$query = $this->db->query("	SELECT  HEX(u.user_id) as user_id, u.nama, u.is_aktif, u.password, HEX(g.group_id) as group_id, g.nama as gnama
			FROM  s_user u 
			JOIN  s_user_group ug ON u.user_id = ug.user_id
			JOIN  s_group g ON ug.group_id = g.group_id
			WHERE   u.username = ?", [$username]);
		if($query->num_rows() == 1){
			$query = $query->row();

			if($query->is_aktif){
				if(password_verify($password, $query->password)){
					$message = 'Login Berhasil';
					$result = $query;
					$status = 200;
				} else {
					$message = 'Username dan Password salah';
				}
			} else {
				$message = 'User tidak aktif.';
			}
		} else {
			$message = 'Username dan Password salah';
		}

		$this->response([
			'status'=> $status,
			'message'=> $message,
			'data'=> $result,
		], $status);
	}

}