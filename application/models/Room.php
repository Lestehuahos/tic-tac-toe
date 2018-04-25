<?php

namespace application\models;

use application\core\Model;

class Room extends Model {

	// Создаём новую комнату
	public function createRoom($post) {

		$params = [
			'name' => $_POST['name'],
			'date' => time(),
			'owner' => $this->userID,
		];

		//Создаём комнату
		$this->db->query("INSERT INTO rooms (name, date, owner) VALUES (:name, :date, :owner)", $params);

		$room = $this->db->lastInsertId();

		$params = [
			'user_id' => $this->userID,
			'room_id' => $room,
			'sign' => $this->randomSignToss(),
		];

		//Добавляем создателя в список участников комнат
		$this->db->query("INSERT INTO room_members (user_id, room_id, sign) VALUES (:user_id, :room_id, :sign)", $params);
		
		$params = [
			'id' => $this->userID,
			'room' => $room,
		];
		
		//Добавляем ID комнаты в профиль пользователя
		$this->db->query("UPDATE users SET room = :room WHERE id = :id", $params);
		
	}
	
	// Выбор знака (крестика или нолика)
	public function randomSignToss() {
		// х или 0
		$random = rand(0,100);
		if($random > 50) { // 50% вероятность
			$sign = 1; // крестик
		}
		else {
			$sign = 0; // нолик
		}
		
		return $sign;
	}
	
	// Проверяем существование комнаты
	public function isRoomExists($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM rooms WHERE id = :id', $params);
	}

	// Ход игрока
	public function addMove($id) {
		
		if($this->roomStatus() == 1) {
			/* Если сейчас Ваша очередь */
			if($this->isYourTurn()) {
				// Если выбранная ячейка не заполнена
				if($this->isCellNotFill($id)) {
				
					// Параметры
					$params = [
						'cell' => $id,
						'user_id' => $this->userID,
						'room_id' => $this->currentUserRoom,
					];
					
					// Добавляем ход в таблицу ходов
					$this->db->query("INSERT INTO moves (cell, user_id, room_id) VALUES (:cell, :user_id, :room_id)", $params);

					$params = [
						'last_move' => time(),
						'user_id' => $this->userID,
						'room_id' => $this->currentUserRoom,
					];
					
					// Передаём ход противнику
					$this->changeMove();
					
					// Обновляем дату последнего хода
					$this->db->query("UPDATE room_members SET last_move = :last_move WHERE user_id = :user_id AND room_id = :room_id", $params);
				}
				else {
					"Вы не можете совершить этот ход";
				}
			}
			else {
				echo "Сейчас не ваша очередь";
			}
		}
		elseif($this->roomStatus() == 2) {
			echo "Игра окончена";
		}
		elseif($this->roomStatus() == 0) {
			echo "Игра ещё не началась";
		}
	}

	public function getUserCurrentGameId() {

		$params = [
			'user_id' => $this->userID,
			'room_id' => $this->currentUserRoom,
		];

		$userDate = $this->db->row('SELECT * FROM room_members WHERE user_id = :user_id AND room_id = :room_id', $params);

		return $userDate[0]['id'];
	}

	// Получить состояние доски (с ходами)
	public function getBoard() {
	
		$params = [
			'room_id' => $this->currentUserRoom,
		];
		
		return $this->db->row('SELECT moves.*, room_members.sign FROM moves INNER JOIN room_members ON moves.user_id = room_members.user_id WHERE moves.room_id = :room_id', $params);	
	}
	
	//	Выбираем ID игрока, у которого указанный знак
	public function getPlayerSign($sign) {
	
		$params = [
			'room_id' => $this->currentUserRoom,
			'sign' => $sign,
		];
		
		// Выбираем ID игрока, у которого указанный знак
		$player = $this->db->row('SELECT user_id FROM room_members WHERE room_id = :room_id AND sign = :sign', $params);
		
		return $player[0]['user_id'];
	}
	
	// Получить данные о комнате и проверка подсоединения игрока
	public function getRoom() {
	
		$params = [
			'id' => $this->currentUserRoom,
		];
		
		/* Извлекаем информацию о статусе комнаты */
		$room = $this->db->row('SELECT * FROM rooms WHERE id = :id', $params);
		
		/* Если не вышло 90 секунд*/
		if(time() <= $room[0]['date'] + 90) {
		
			$params = [
				'room_id' => $this->currentUserRoom,
			];
			
			// Получаем количество участников комнаты 
			$members = $this->db->row('SELECT COUNT(*) as count FROM room_members WHERE room_id = :room_id', $params);
			
			$total = $members[0]['count'];
			
			/* Если в комнате два участника*/
			if($total == 2) {
			
				$params = [
					'status' => 1,
					'id' => $this->currentUserRoom,
					'current_player' => $this->getPlayerSign(1),
					'start_move' => time(),
				];	
				
				/* Делаем комнату активной, записываем текущего игрока и время старта хода */
				$this->db->query('UPDATE rooms SET status = :status, current_player = :current_player, start_move = :start_move WHERE id = :id', $params);
				
				header('Location: /room/room/');
			}
			else {
				echo abs(time() - ($room[0]['date'] + 90));
			}		
		}
		else {
			$this->deleteRoom();
			//echo 'success';
		}
	}

	// Проверка окончания игры
	public function isGameTheEnd() {

		$params = [
			'room_id' => $this->currentUserRoom,
		];
			
		$cells = $this->db->row('SELECT cell FROM moves WHERE room_id = :room_id', $params);

		$params = [
			'room_id' => $this->currentUserRoom,
			'user_id' => $this->getPlayerSign(1),
		];
		
		// Получаем значения ходов, где стоит крестик
		$x_moves = $this->db->row('SELECT cell FROM moves WHERE room_id = :room_id AND user_id = :user_id', $params);

		$xcells = array();
		
		foreach($x_moves as $key => $value) {
			$xcells[$value['cell']] = 1;
		}
				
		$params = [
			'room_id' => $this->currentUserRoom,
			'user_id' => $this->getPlayerSign(0),
		];
		
		// Получаем значения ходов, где стоит нолик
		$y_moves = $this->db->row('SELECT cell FROM moves WHERE room_id = :room_id AND user_id = :user_id', $params);
		
		$ycells = array();
		
		foreach($y_moves as $key => $value) {
			$ycells[$value['cell']] = 0;
		}
		
		/* Если сделанных ходов меньше девяти */
		if($this->totalMovesCount() < 9) {
		
			if($this->winnerCheck($xcells)) {
				$this->shutTheRooom();
				
				$params = [
					'id' => $this->getPlayerSign(1),
					'wins' => 1,
					'matches' => 1,
				];
				
				$this->db->query('UPDATE users SET wins = wins + :wins, matches = matches + :matches WHERE id = :id', $params);
				
				$params = [
					'id' => $this->getOppositePlayer($this->getPlayerSign(1)),
					'defeats' => 1,
					'matches' => 1,
				];
				
				$this->db->query('UPDATE users SET defeats = defeats + :defeats, matches = matches + :matches WHERE id = :id', $params);
				
				echo "Победили крестики";
			}
			elseif($this->winnerCheck($ycells)) {
				$this->shutTheRooom();
				
				$params = [
					'id' => $this->getPlayerSign(0),
					'wins' => 1,
					'matches' => 1,
				];
				
				$this->db->query('UPDATE users SET wins = wins + :wins, matches = matches + :matches WHERE id = :id', $params);
				
				$params = [
					'id' => $this->getOppositePlayer($this->getPlayerSign(0)),
					'defeats' => 1,
					'matches' => 1,
				];
				
				$this->db->query('UPDATE users SET defeats = defeats + :defeats, matches = matches + :matches WHERE id = :id', $params);
				
				echo "<center>Победили нолики</center>";
			}		
		}
		else {

			$params = [
				'id' => $this->getPlayerSign(0),
				'matches' => 1,
			];
			
			$this->db->query('UPDATE users SET matches = matches + :matches WHERE id = :id', $params);

			$params = [
				'id' => $this->getPlayerSign(1),
				'matches' => 1,
			];
			
			$this->db->query('UPDATE users SET matches = matches + :matches WHERE id = :id', $params);			

			echo "Ничья";
			$this->shutTheRooom();
		}
	}

	// Проверка победных комбинаций
	public function winnerCheck($cells) {
	
		if (isset($cells[0]) && isset($cells[1]) && isset($cells[2])) {
			$result = true;
			echo "0";
		}
		elseif (isset($cells[3]) && isset($cells[4]) && isset($cells[5])) {
			$result = true;
			echo "2";
		}
		elseif (isset($cells[6]) && isset($cells[7]) && isset($cells[8])) {
			$result = true;
			echo "3";
		}
		elseif (isset($cells[0]) && isset($cells[3]) && isset($cells[6])) {
			$result = true;
			echo "4";
		}
		elseif (isset($cells[1]) && isset($cells[4]) && isset($cells[7])) {
			$result = true;
			echo "5";
		}
		elseif (isset($cells[2]) && isset($cells[5]) && isset($cells[8])) {
			$result = true;
			echo "6";
		}
		elseif (isset($cells[0]) && isset($cells[4]) && isset($cells[8])) {
			$result = true;
			echo "7";
		}
		elseif (isset($cells[2]) && isset($cells[4]) && isset($cells[6])) {
			$result = true;
			echo "8";
		}
		else {
			$result = false;
		}
		
		return $result;
	
	}
	
	// Установка статуса матча (комнаты) в состояние завершенного
	public function shutTheRooom() {
	
		$params = [
			'status' => 2,
			'id' => $this->currentUserRoom,
		];
		
		$this->db->query('UPDATE rooms SET status = :status WHERE id = :id', $params);
		
	}
	
	// Количество ходов, сделанных в конкретном матче
	public function totalMovesCount() {
	
		$params = [
			'room_id' => $this->currentUserRoom,
		];
	
		$result = $this->db->column('SELECT COUNT(*) as quantity FROM moves WHERE room_id = :room_id', $params);
		
		return $result;	
	}
	
	// Узнаём статус комнаты
	// 0 - ожидает подключения противника
	// 1 - матч идёт
	// 2 - матч закончен 
	public function roomStatus() {
	
		$params = [
			'id' => $this->currentUserRoom,
		];
	
		$result = $this->db->column('SELECT status FROM rooms WHERE id = :id', $params);
		
		return $result;	
	}
	
	public function isCellNotFill($id) {
	
		$params = [
			'room_id' => $this->currentUserRoom,
			'cell' => $id,
		];
	
		$result = $this->db->column('SELECT cell FROM moves WHERE room_id = :room_id AND cell = :cell', $params);
		
		/* Если в ячейке уже есть значение*/
		if($result) {
			return false;
		}
		else {
			return true;
		}
		
	}
	
	// Очищаем комнату пользователя 
	public function userRoomClear() {
		
			$params = [
						'room' => 0,
						'id' => $this->userID,
					];
			
			$this->db->query('UPDATE users SET room = :room WHERE id = :id', $params);
		
	}
	
	// Удаляем комнату 
	public function deleteRoom() {
	
		$params = [
					'id' => $this->currentUserRoom,
				];
		
		// Удаляем комнату
		$this->db->query('DELETE FROM rooms WHERE id = :id', $params);
		
		// Убираем информацию о комнате из профиля пользователя
		$this->userRoomClear();
		
		$params = [
					'room_id' => $this->currentUserRoom,
				];
		
		// Удаляем участников комнаты (но не профили)
		$this->db->query('DELETE FROM room_members WHERE room_id = :room_id', $params);	
	}
	
	// Получаем знак создателя комнаты (крестик или нолик)
	public function getRoomOwnerSign($id) {
	
		$params = [
			'room_id' => $id,
		];
	
		$result = $this->db->column('SELECT sign FROM room_members WHERE room_id = :room_id', $params);
		
		return $result;
	}
	
	// Присоединение игрока к существующей комнате
	public function joinToRoom($id) {
		
		$params = [
					'room' => $id,
					'id' => $this->userID,
				];
		
		// Добавляем ID комнаты в профиль пользователя
		$this->db->query('UPDATE users SET room = :room WHERE id = :id', $params);
		
		if($this->getRoomOwnerSign($id) == 0) {
			$sign = 1;
		}
		else {
			$sign = 0;
		}
		
		$params = [
			'user_id' => $this->userID,
			'room_id' => $id,
			'sign' => $sign,
		];
		
		// Добавляем нового участника комнаты 
		$this->db->query("INSERT INTO room_members (user_id, room_id, sign) VALUES (:user_id, :room_id, :sign)", $params);	 
	}

	// Взять противоположного игрока 
	public function getOppositePlayer($id) {
	
		$params = [
			'room_id' => $this->currentUserRoom,
			'user_id' => $id,
		];
	
		$oppositeId = $this->db->column('SELECT user_id FROM room_members WHERE room_id = :room_id AND user_id != :user_id', $params);
		
		return $oppositeId;
	}
	
	// Проверяет, очередь ли сейчас игрока
	public function isYourTurn() {
	
		$params = [
			'id' => $this->currentUserRoom,
			'current_player' => $this->userID,
		];
	
		$user = $this->db->row('SELECT * FROM rooms WHERE id = :id AND current_player = :current_player', $params);
		
		// Если такая запись существует
		if($user) {
			return true;
		}
		else { // иначе
			return false;
		}
	}
	
	// Сменить ход
	public function changeMove() {
	
		// Текущая комната
		$params = [
			'id' => $this->currentUserRoom,
		];
		
		/* Извлекаем информацию о статусе комнаты */
		$room = $this->db->row('SELECT * FROM rooms WHERE id = :id', $params);
		
		// Получаем ID текущего игрока, чья очередь сейчас ходить
		$currentPlayer = $room[0]['current_player'];
		
		$params = [
			'id' => $this->currentUserRoom,
			'current_player' => $this->getOppositePlayer($currentPlayer),
			'start_move' => time(),
		];
		
		$this->db->query('UPDATE rooms SET current_player = :current_player, start_move = :start_move WHERE id = :id', $params);
	}
	
	// Поддержание очередности ходов
	public function movesPriority() {
		
		// Текущая комната
		$params = [
			'id' => $this->currentUserRoom,
		];
		
		/* Извлекаем информацию о статусе комнаты */
		$room = $this->db->row('SELECT * FROM rooms WHERE id = :id', $params);
		
		// Получаем ID текущего игрока, чья очередь сейчас ходить
		$currentPlayer = $room[0]['current_player'];
		
		/* Если в данном матче это первый ход */
		/*
		if($this->totalMovesCount() == 0) {
			$moveStart = $room[0]['start_move']; // присваиваем в качестве времени начала текущего хода время старта матча
		}
		else { // иначе
			$moveStart = $room[0]['start_move']; //присваиваем время начала хода
		}
		*/
		
		/* Если текущий ход ещё не закончился */
		//if(time() <= $moveStart + 10) {
			
			if($this->roomStatus() == 1) {
				/* Если ход игрока */
				if($currentPlayer === $this->userID) {
				
				if($this->getPlayerSign(1) == $this->userID) {
					$sign = 'x';
				}
				else {
					$sign = 'o';
				}
					echo 'Ваш ход ('.$sign.')';
				}
				else {
					echo 'Ход противника';
				}
			}
			else {
			
				if($this->roomStatus() == 2) {
					echo 'Игра окончена';
				}
				
				if($this->roomStatus() == 0) {
					echo 'Ожидайте противника';
				}
				
			}
			
			//echo abs(time() - ($moveStart + 10));
		//}
		//else {
			//$this->db->query('UPDATE rooms SET current_player = :current_player WHERE id = :id', $params);
		//}
	
	}
	
	// Проверяем, есть ли у игрока комната
	public function isUserInRoom() {

		$params = [
			'id' => $this->userID,
		];

		$user = $this->db->row('SELECT * FROM users WHERE id = :id AND room > 0', $params);
		
		if($user) {
			return true;
		}
		else {
			return false;
		}	
	}

}