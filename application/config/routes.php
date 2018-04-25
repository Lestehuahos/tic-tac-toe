<?php

return [

	'' => [
		'controller' => 'main',
		'action' => 'index',
	],

	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],

	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],

	'room/room' => [
		'controller' => 'room',
		'action' => 'room',
	],

	'room/connect' => [
		'controller' => 'room',
		'action' => 'connect',
	],
	
	'room/wait' => [
		'controller' => 'room',
		'action' => 'wait',
	],

	'room/join/{id:\d+}' => [
		'controller' => 'room',
		'action' => 'join',
	],

	'room/add' => [
		'controller' => 'room',
		'action' => 'add',
	],
	
	'room/exit' => [
		'controller' => 'room',
		'action' => 'exit',
	],

	'room/move/{id:\d+}' => [
		'controller' => 'room',
		'action' => 'move',
	],	
	
	'room/save' => [
		'controller' => 'room',
		'action' => 'save',
	],

	'account/save' => [
		'controller' => 'account',
		'action' => 'save',
	],

	'account/authorization' => [
		'controller' => 'account',
		'action' => 'authorization',
	],
	
	'account/profile' => [
		'controller' => 'account',
		'action' => 'profile',
	],
	
];