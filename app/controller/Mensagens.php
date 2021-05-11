<?php

namespace app\controller;

use \app\core\Views;

class Mensagens
{
	public static function Erro(string $mensagem)
	{
		self::Mensagem(['Mensagem' => $mensagem, 'Tipo' => 'danger', 'Subtitulo' => 'Erro'], 'Erro');
	}

	public static function Aviso(string $mensagem)
	{
		self::Mensagem(['Mensagem' => $mensagem, 'Tipo' => 'warning', 'Subtitulo' => 'Aviso'], 'Aviso');
	}

	public static function Info(string $mensagem)
	{
		self::Mensagem(['Mensagem' => $mensagem, 'Tipo' => 'light', 'Subtitulo' => 'Informação'], 'Informação');
	}

	private static function Mensagem(array $Params, string $Title)
	{
		Views::Carrega('main.message', $Params, $Title);
	}
}