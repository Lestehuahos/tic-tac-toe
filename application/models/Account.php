<?php

namespace application\models;

use application\core\Model;

class Account extends Model {

	public $error;
	
	public function authorizationCheck($post) {
	
		if (isset($_REQUEST['send'])) {
		
			//Значения из POST
			$name = $_POST['name'];
			$password = $_POST['password'];
			
			$params = [
				'name' => $name,
				'password' => md5($password),
			];
			
			$result = $this->db->row('SELECT * FROM users WHERE name = :name AND password = :password', $params);
			//print_r($result);

			if($result) {
				setcookie('login', $result[0]['name'], time() + 86400 * 365, '/');
				setcookie('password', md5($password), time() + 86400 * 365, '/');
				//$this->view->redirect('/');
			}
			else {
				echo 'Пользователь не найден';
			}
			
		}
	}

	public function contactValidate($post) {
	
		if (isset($_REQUEST['send'])) {
			
			//Значения из POST
			$name = $_POST['name'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			$email = $_POST['email'];
			$sex = $_POST['sex'];
			
			$params = [
				'name' => $name,
				'password' => md5($password),
				'email' => $email,
				'sex' => $sex,
			];

			$this->db->query("INSERT INTO users (name, password, email, sex) VALUES (:name, :password, :email, :sex)", $params);

		}
	}
	
	// Получаем статистику пользователя (для профиля)
	public function getStatistics() {
	
		$params = [
			'id' => $this->userID,
		];
		
		$result = $this->db->row('SELECT * FROM users WHERE id = :id', $params);
		
		return $result;
		
	}
}
