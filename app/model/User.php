<?php
namespace app\model;

use \app\core\Db;
use \app\controller\MessageController;
use \app\core\Base;
use \app\core\Request;
use \app\core\Session;
use \app\core\Models;

class User extends Models
{
	protected $DefaultData = [
		'id'			=> null,
		'name'		=> '',
		'email'		=> '',
		'passwd'		=> '',
		'admin'		=> false
	];

	private $UserData;

	const LevelAdmin	= 1;
	const TABLE = TBL_PREFIX.'users';

	public function __construct(int $userid = 0)
	{
		parent::__construct();
		$this->UserData 		= new \stdClass();
		$this->DefaultData 	= (object) $this->DefaultData;

		if($userid > 0)
		{
			$this->Find($userid);
		}
	}

	public static function List(array $CustomWhere = [])
	{
		$DB = new Db(DB_HOST,DB_NAME,DB_USER,DB_PASS);
		$SqlQuery = '';
		$ParamsQuery = null;
		if(!empty($CustomWhere))
		{
			$SqlQuery .= ' WHERE '.$CustomWhere[0];
			$ParamsQuery = $CustomWhere[1];
		}

		$UserList = $DB->SelectSql('SELECT id, name, email, passwd, admin FROM '.self::TABLE, 0, $ParamsQuery);

		return $UserList ?: [];
	}

	public function userdata()
	{
		return !empty((array)$this->UserData)
					? $this->UserData
					: $this->DefaultData;
	}

	public static function Logged()
	{
		if(!Session::Get('userdata')) return false;
		else
		{
			$User = (new User(Session::Get('userdata')->id));
			if(!$User) return false;
		}
		return true;
	}

	public static function RequireLogin()
	{
		if(!self::Logged())
		{
			Request::Redirect('/login');
		}
	}

	public function Find($search, $params = [], $compare = 'OR')
	{
		if(isset($this->UserData->id))
			return $this;

		if(is_array($search))
		{
			$Params = [];
			$Where = [];
			foreach ($search as $KeySearch => $ValueSearch)
			{
				$Where[] = $KeySearch.' = ?';
				$Params[] = $ValueSearch;
			}
			$Where = implode(' '.$compare.' ', $Where);
		}
		elseif(Base::Numeric($search))
		{
			$Where  = 'id = ?';
			$Params = [$search];
		}
		elseif(empty($search) || empty($params))
		{
			die('Invalid parameters user search');
		}

		$User = $this->DB->SelectSql('SELECT * FROM '.self::TABLE.' WHERE '.$Where, 1, $Params);

		$User = $this->FillData($User);

		$this->UserData = $User;

		return $User;
	}

	public function Create(array $userData)
	{
		if(empty($userData)) return false;

		$userData = $this->FillData($userData);

		foreach(['name', 'email', 'passwd'] as $Field)
		{
			if(empty($userData->{$Field}))
			{
				MessageController::Message('Field "'.ucfirst($Field).'" Cannot to be empty.');
				return false;
			}
		}

		$userData->passwd = self::PasswdHash($userData->passwd);

		$Status = $this->DB->Insert(self::TABLE, $userData);

		if($Status !== false)
		{
			Request::Redirect('/users');
		}
		return false;
	}

	public function Update(array $userData)
	{
		if(empty($userData)) return false;

		$FieldsUpdated = $this->FilterUpdateFields($userData);

		if(empty($FieldsUpdated))
		{
			MessageController::Message('User data to update empty.');
			return false;
		}

		if(!empty($FieldsUpdated['passwd']))
		{
			$FieldsUpdated['passwd'] = self::PasswdHash($FieldsUpdated['passwd']);
		}

		$Status = $this->DB->Update(self::TABLE, $this->UserData->id, $FieldsUpdated);

		Request::Redirect('/users');
	}

	public function Delete(int $userid)
	{
		if(empty($this->UserData)) return false;
		$Status = $this->DB->CustomQuery('DELETE FROM '.$this->Tabela.' WHERE id = ?', [$userid]);

		return $Status !== false;
	}

	private static function PasswdHash($passwd)
	{
		return password_hash($passwd, PASSWORD_BCRYPT);
	}
}