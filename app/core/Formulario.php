<?php
namespace app\core;

use \app\core\Session;
use \app\core\Request;

class Formulario
{
	public static function GeraHash()
	{
		$DataHash = [
			$_SERVER['REQUEST_URI'],
			time(),
			uniqid()
		];

		$Hash = sha1(implode('', $DataHash));
		Session::Set('HashForm', $Hash);
		return $Hash;
	}

	public static function VerificaHash(string $RotaFalha)
	{
		$Post = Request::Input();
		if(!isset($Post['hash_form'])) Request::Direciona($RotaFalha);
		else
		{
			$HashSessao = Session::Get('HashForm');
			if($Post['hash_form'] !== $HashSessao)
			{
				Request::Direciona($RotaFalha);
			}
		}
	}
}