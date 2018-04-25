<?php

namespace application\controllers;

use application\core\Controller;

class RoomController extends Controller {

	public function addAction() {
		$this->view->render('Создать комнату');	
	}

	//Сохранить комнату
	public function saveAction() {
		$this->model->createRoom($_POST);
		$this->view->redirect('/room/room');
	}

	public function roomAction() {
		if($this->model->isUserInRoom()) {
			$result = $this->model->getBoard();

			$vars = [
				'moves' => $result,
			];
			
			// Если матч в процессе
			if($this->model->roomStatus() == 1) {
				$this->model->isGameTheEnd();
			}

			$this->view->render('Комната', $vars);
		}
		else {
			echo "У вас нет комнаты";
		}
	}
	
	// Делаем ход
	public function moveAction() {
		$this->model->addMove($this->route['id']);
		$this->view->redirect('/room/room');
	}
	
	//Подключение игрока к комнате
	public function joinAction() {
		$this->model->joinToRoom($this->route['id']);
		$this->view->redirect('/room/room');
	}
	
	// Ожидание подключения противника
	public function connectAction() {
		
		//Если комната в ожидании подключения игрока
		if($this->model->roomStatus() == 0) {
			$this->model->getRoom();
		}
	}
	
	// Ожидание хода игрока
	public function waitAction() {
		$this->model->movesPriority();
	}
	
	// Выйти из комнаты 
	public function exitAction() {
		$this->model->deleteRoom();
	}
	
}