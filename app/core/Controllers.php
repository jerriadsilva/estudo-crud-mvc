<?php
namespace app\core;

class Controllers
{
	private static function ExtractControllerElements($ControllerString)
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

	public static function CallController($controller, array $PathParams = [])
	{
		$ControllerElements = self::ExtractControllerElements($controller);
		if(!$ControllerElements) return false;

		call_user_func_array([
			new $ControllerElements->Controller,
			$ControllerElements->Method
		], array_values($PathParams));

	}
}