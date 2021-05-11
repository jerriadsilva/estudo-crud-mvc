<?php
namespace app\core;

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

		require BASEDIR.'/app/views.globals.php';

		require $layoutFile;

		die();
	}
}