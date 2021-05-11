<?php
namespace app\core;

use app\controller\Mensagens;

class Controllers
{
	private static function ExtraiElementosController($ControllerString)
	{
		if(strpos($ControllerString, '@') > 0)
		{
			$ControllerString = explode('@', $ControllerString);
			return (object)[
				'Controller'		=> 'app\\controller\\'.$ControllerString[0],
				'Method'				=> $ControllerString[1]
			];
		}

		return false;
	}

	public static function ExecutaController($controller, array $PathParams = [])
	{
		$ControllerElements = self::ExtraiElementosController($controller);
		if(!$ControllerElements) return false;

		if(!class_exists($ControllerElements->Controller))
		{
			Mensagens::Erro('Não existe o controller "'.$ControllerElements->Controller.'"');
		}
		elseif(!method_exists($ControllerElements->Controller, $ControllerElements->Method))
		{
			Mensagens::Erro('Não existe o metodo "'.$ControllerElements->Method.'" para o controller "'.$ControllerElements->Controller.'"');
		}

		call_user_func_array([
			new $ControllerElements->Controller,
			$ControllerElements->Method
		], array_values($PathParams));

	}
}