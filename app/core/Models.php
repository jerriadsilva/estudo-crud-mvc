<?php
namespace app\core;

class Models
{
	protected $DB;
	protected function __construct()
	{
		$this->DB = new Db(DB_HOST,DB_NAME,DB_USER,DB_PASS);
	}
	protected function FiltraCamposUpdate(array $Data)
	{
		$ColunasTmp = [];
		foreach($Data as $Coluna => $Valor)
		{
			if(!isset($this->DefaultData->{$Coluna})) continue;

			$ColunasTmp[$Coluna] = $Valor;
		}
		return $ColunasTmp;
	}

	protected function PreencheDados(array $Dados)
	{
		$DadosRetorno = [];
		foreach($this->DefaultData as $Coluna => $Valor)
		{
			$DadosRetorno[$Coluna] = $Dados[$Coluna] ?? $Valor;
		}
		return (object) $DadosRetorno;
	}

}