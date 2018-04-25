<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

	public function loginAction() {
		$this->view->render('Вход');
	}
	
	public function registerAction() {
		$this->view->render('Регистрация');
	}
	
	public function saveAction() {
		$this->model->contactValidate($_POST);
	}
	
	public function authorizationAction() {
		$this->model->authorizationCheck($_POST);
	}
	
	//Профиль (со статистикой игр, побед, поражений)
	public function profileAction() {
		
		$result = $this->model->getStatistics();
		
		$vars = [
			'user' => $result,
		];
		
		$this->view->render('Статистика', $vars);
	}

}