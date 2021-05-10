<?php

namespace app\controller;

use \app\core\Views;

class MessageController
{
	public static function Message(string $message, int $type = 0)
	{
		Views::load('main.message', ['Message' => $message, 'type' => $type], '', 'Warning');
	}
}