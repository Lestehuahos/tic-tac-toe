<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {

	public function indexAction() {	

		$result = $this->model->getRooms();

		$vars = [
			'rooms' => $result,
		];

		$this->view->render('Главная страница', $vars);

	}
		
}