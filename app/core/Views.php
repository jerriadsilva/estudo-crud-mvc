<?php
namespace app\core;

use \app\core\Session;
use \app\model\User;

class Views
{
	public static function load(string $view, $Params = [], $PageSubTitle = '', $PageTitle = '')
	{
		$ViewList = explode('.', $view);

		$LayoutFile = array_shift($ViewList);
		$viewFile = implode('/', $ViewList);

		$layoutFile = NormalizePath(BASEDIR.'app/view/layout/'.$LayoutFile.'.php');
		$viewFile = NormalizePath(BASEDIR.'app/view/'.$viewFile.'.php');

		if(!file_exists($viewFile) || !file_exists($layoutFile))
		{
			die('Incorrect layout or view file');
		}

		$Params = $Params??[];
		foreach($Params as $VariableName => $VariableValue)
		{
			${$VariableName} = $VariableValue;
		}

		$LoggedUser = (new User(Session::Get('userdata')->id??0))->userdata();

		require $layoutFile;

		die();
	}
}