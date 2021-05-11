<?php
namespace app\model;

use \app\core\Db;
use \app\controller\Mensagens;
use \app\core\Base;
use \app\core\Request;
use \app\core\Models;

class Produto extends Models
{
	protected $DefaultData = [
		'id'				=> null,
		'nome'			=> '',
		'descricao'		=> '',
		'valor'			=> ''
	];

	private $Produto;

	const TABLE = TBL_PREFIX.'produtos';

	public function __construct(int $codproduto = 0)
	{
		parent::__construct();
		$this->Produto 			= new \stdClass();
		$this->DefaultData 			= (object) $this->DefaultData;

		if($codproduto > 0)
		{
			$this->Busca($codproduto);
		}
	}

	public static function Lista(array $CustomWhere = [])
	{
		$DB = new Db(DB_HOST,DB_NAME,DB_USER,DB_PASS);
		$SqlQuery = '';
		$ParamsQuery = null;
		if(!empty($CustomWhere))
		{
			$SqlQuery .= ' WHERE '.$CustomWhere[0];
			$ParamsQuery = $CustomWhere[1];
		}
		$Produtos = $DB->SelectSql('SELECT id, nome, descricao, valor FROM '.self::TABLE.$SqlQuery, 0, $ParamsQuery);

		return $Produtos ?: [];
	}

	public function Dados()
	{
		return !empty((array)$this->Produto)
					? $this->Produto
					: $this->DefaultData;
	}

	public function Busca($busca, $params = [], $compare = 'OR')
	{
		if(isset($this->Produto->id))
			return $this;

		if(is_array($busca))
		{
			$Params = [];
			$Where = [];
			foreach ($busca as $KeySearch => $ValueSearch)
			{
				$Where[] = $KeySearch.' = ?';
				$Params[] = $ValueSearch;
			}
			$Where = implode(' '.$compare.' ', $Where);
		}
		elseif(Base::Numeric($busca))
		{
			$Where  = 'id = ?';
			$Params = [$busca];
		}
		elseif(empty($busca) || empty($params))
		{
			Mensagens::Erro('Parâmetros de busca de produto inválida');
		}

		$Produto = $this->DB->SelectSql('SELECT * FROM '.self::TABLE.' WHERE '.$Where, 1, $Params);

		$Produto = $this->PreencheDados((array) $Produto);

		$this->Produto = $Produto;

		return $Produto;
	}

	public function Criar(array $dadosProduto)
	{
		if(empty($dadosProduto)) return false;

		$dadosProduto = $this->PreencheDados($dadosProduto);

		foreach(['nome', 'descricao'] as $Coluna)
		{
			if(empty($dadosProduto->{$Coluna}))
			{
				Mensagens::Erro('Campo "'.ucfirst($Coluna).'" não pode estar vazio.');
				return false;
			}
		}

		$Status = $this->DB->Insert(self::TABLE, $dadosProduto);

		if($Status !== false)
		{
			Request::Direciona('/produtos');
		}
		elseif($this->DB->MysqlError)
		{
			Mensagens::Erro($this->DB->MysqlError);
		}
		return false;
	}

	public function Update(array $dadosProduto)
	{
		if(empty($dadosProduto)) return false;

		$ColunasFIltradas = $this->FiltraCamposUpdate($dadosProduto);

		if(empty($ColunasFIltradas))
		{
			Mensagens::Aviso('Sem dados a serem atualizados.');
			return false;
		}

		foreach(['nome', 'descricao'] as $Coluna)
		{
			if(empty($ColunasFIltradas[$Coluna]))
			{
				Mensagens::Erro('Campo "'.ucfirst($Coluna).'" não pode estar vazio.');
				return false;
			}
		}

		$Status = $this->DB->Update(self::TABLE, $this->Produto->id, $ColunasFIltradas);

		if($Status !== false)
		{
			Request::Direciona('/produtos');
		}
		elseif($this->DB->MysqlError)
		{
			Mensagens::Erro($this->DB->MysqlError);
		}
	}

	public function Remover(int $codproduto)
	{
		if(empty($this->Produto)) return false;
		$Status = $this->DB->CustomQuery('DELETE FROM '.$this->Tabela.' WHERE id = ?', [$codproduto]);

		return $Status !== false;
	}
}