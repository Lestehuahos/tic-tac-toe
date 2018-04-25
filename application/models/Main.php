<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	//Получить список комнат
	public function getRooms() {
		
		$params = [
			'status' => 0,
		];
	
		$result = $this->db->row('SELECT * FROM rooms WHERE status = :status', $params);
		return $result;
	}

	//Добавить игрока в комнату
	public function joinUserToRoom() {

		$params = [
			'room_id' => $post['name'],
		];

		$this->db->query('INSERT INTO users_rooms VALUES (:room_id, :user_id)', $params);
	}
	
}