<?php
namespace app\core;

class Views
{
	public static function load(string $view, $Params = [], $PageTitle = '')
	{
		$ViewList = explode('.', $view);

		$LayoutFile = array_shift($ViewList);
		$viewFile = implode('/', $ViewList);

		$layoutFile = NormalizePath(BASEDIR.'app/view/layout/'.$LayoutFile.'.php');

		if(!file_exists($layoutFile))
		{
			die('Incorrect layout file');
		}

		if(!empty($viewFile))
		{
			$viewFile = NormalizePath(BASEDIR.'app/view/'.$viewFile.'.php');

			if(!file_exists($viewFile))
			{
				die('Incorrect view file');
			}
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