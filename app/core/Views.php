<?php
namespace app\core;

class Views
{
	/*
	 * Carrega uma view especifica
	 * O primeiro item sempre deve ser um layout principal, que fica na pasta app/views/layout, e o restante o caminho dentro de app/views para a view desejada
	 * @param String $view: Layout e view a serem carregadas, no formato "layout_principal:path_da_view", onde o path da view é separada por (.) , sendo o primeiro item o layout principal, e o restante, o layout de conteudo
	 * @param Array $params: Array Parâmetros que serão passados para a view, onde a chave de cada item será o nome da variável a ser disponibilizada
	 * @param String $TituloPagina: Titulo da página
	*/
	public static function Carrega(string $view, $params = [], string $TituloPagina = '')
	{
		$Params = explode(':', $view);

		$ArqLayout = $Params[0];
		$Conteudo = !empty($Params[1])
						? implode('/', explode('.', $Params[1]))
						: '';

		$ArqLayout = NormalizaPath(BASEDIR.'app/view/layout/'.$ArqLayout.'.php');

		if(!file_exists($ArqLayout))
		{
			die('Incorrect layout file');
		}

		if(!empty($Conteudo))
		{
			$Conteudo = NormalizaPath(BASEDIR.'app/view/'.$Conteudo.'.php');

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