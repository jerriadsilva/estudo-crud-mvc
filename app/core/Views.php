<?php
namespace app\core;

class Views
{
	public static function Carrega(string $view, $params = [], $PageTitle = '')
	{
		$ViewStr = explode('.', $view);

		$ArqLayout = array_shift($ViewStr);
		$Conteudo = implode('/', $ViewStr);

		$ArqLayout = NormalizePath(BASEDIR.'app/view/layout/'.$ArqLayout.'.php');

		if(!file_exists($ArqLayout))
		{
			die('Incorrect layout file');
		}

		if(!empty($Conteudo))
		{
			$Conteudo = NormalizePath(BASEDIR.'app/view/'.$Conteudo.'.php');

			if(!file_exists($Conteudo))
			{
				die('Incorrect view file');
			}
		}

		$params = $params??[];
		foreach($params as $VariableName => $VariableValue)
		{
			${$VariableName} = $VariableValue;
		}

		require BASEDIR.'/app/views.globals.php';

		require $ArqLayout;

		die();
	}
}