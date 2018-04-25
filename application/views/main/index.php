<p>Главная страница | <a href="/account/register">Регистрация </a> | <a href="/account/login">Войти</a>
| <a href="/room/add">Создать комнату</a>| <a href="/room/room">Моя комната</a> | <a href="/account/profile">Мой профиль</a></p>


<?php 
foreach($rooms as $room) {
	echo $room['name']. ' <a href="/room/join/'.$room['id'].'">Присоединиться</a><br><hr>';
} 
?>