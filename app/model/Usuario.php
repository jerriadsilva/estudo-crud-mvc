<?php
namespace app\model;

use \app\core\Db;
use \app\controller\Mensagens;
use \app\core\Base;
use \app\core\Request;
use \app\core\Session;
use \app\core\Models;

class Usuario extends Models
{
	protected $DefaultData = [
		'id'			=> null,
		'nome'		=> '',
		'email'		=> '',
		'passwd'		=> '',
		'admin'		=> false
	];

	private $UserData;

	const TABLE = TBL_PREFIX.'usuarios';

	public function __construct(int $codusuario = 0)
	{
		parent::__construct();

		$this->UserData 		= new \stdClass();
		$this->DefaultData 	= (object) $this->DefaultData;

		if($codusuario > 0)
		{
			$this->Busca($codusuario);
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

		$UserList = $DB->SelectSql('SELECT id, nome, email, passwd, admin FROM '.self::TABLE, 0, $ParamsQuery);

		return $UserList ?: [];
	}

	public function Dados()
	{
		return !empty((array)$this->UserData)
					? $this->UserData
					: $this->DefaultData;
	}

	public static function Logado()
	{
		if(!Session::Get('userdata')) return false;
		else
		{
			$User = (new Usuario(Session::Get('userdata')->id));
			if(!$User) return false;
		}
		return true;
	}

	public static function RequerLogin(bool $SomenteAdmin = true)
	{
		if(!self::Logado())
		{
			Request::Direciona('/login');
		}
		elseif($SomenteAdmin)
		{
			if(!Session::Get('userdata')->admin)
			{
				Request::Direciona('/');
			}
		}
	}

	public function Busca($busca, $params = [], $compare = 'OR')
	{
		if(isset($this->UserData->id))
			return $this;

		if(is_array($busca))
		{
			$Params = [];
			$Where = [];
			foreach ($busca as $KeyBusca => $ValueBusca)
			{
				$Where[] = $KeyBusca.' = ?';
				$Params[] = $ValueBusca;
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
			Mensagens::Erro('Parâmetros de busca de usuário inválida');
		}

		$Usuario = $this->DB->SelectSql('SELECT * FROM '.self::TABLE.' WHERE '.$Where, 1, $Params);

		$Usuario = $this->PreencheDados((array)$Usuario);

		$this->UserData = $Usuario;

		return $Usuario;
	}

	public function Insere(array $dadosUsuario)
	{
		if(empty($dadosUsuario)) return false;

		$dadosUsuario = $this->PreencheDados($dadosUsuario);

		foreach(['nome', 'email', 'passwd'] as $Coluna)
		{
			if(empty($dadosUsuario->{$Coluna}))
			{
				Mensagens::Erro('Campo "'.ucfirst($Coluna).'" não pode estar vazio.');
				return false;
			}
		}

		$dadosUsuario->passwd = self::PasswdHash($dadosUsuario->passwd);

		$Status = $this->DB->Insert(self::TABLE, $dadosUsuario);

		return $Status;
	}

	public function Atualiza(array $userData)
	{
		if(empty($userData)) return false;

		$FieldsUpdated = $this->FiltraCamposUpdate($userData);

		if(empty($FieldsUpdated))
		{
			Mensagens::Aviso('Não foram informados dados a serem atualizados.');
			return false;
		}

		$FieldsUpdated['admin'] = !empty($userData['admin']);

		if(!empty($FieldsUpdated['passwd']))
		{
			$FieldsUpdated['passwd'] = self::PasswdHash($FieldsUpdated['passwd']);
		}

		$Status = $this->DB->Update(self::TABLE, $this->UserData->id, $FieldsUpdated);

		return $Status;
	}

	public function Delete(int $codusuario)
	{
		if(empty($this->UserData)) return false;
		$Status = $this->DB->CustomQuery('DELETE FROM '.$this->Tabela.' WHERE id = ?', [$codusuario]);

		return $Status !== false;
	}

	private static function PasswdHash($passwd)
	{
		return password_hash($passwd, PASSWORD_BCRYPT);
	}
}