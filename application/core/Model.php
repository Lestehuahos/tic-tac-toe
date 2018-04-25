<?php

namespace application\core;

use application\lib\Db;

abstract class Model {

	public $db;
	public $userID;
	public $currentUserRoom;
	
	public function __construct() {
		$this->db = new Db;
	}

	public function authCheck() {
	
		if(isset($_COOKIE['login']) and isset($_COOKIE['password'])) {
			
		    $login = $_COOKIE['login'];
		    $password = $_COOKIE['password'];

			$params = [
				'name' => $login,
				'password' => $password,
			];
			
			$user = $this->db->row('SELECT * FROM users WHERE name = :name AND password = :password', $params);
			
			if($user) {
				$this->userID = $user[0]['id'];
				$this->currentUserRoom = $user[0]['room'];
				//return true;
			}
			else {
				//$this->view->redirect('/account/login');
			}
		}
	}


}