<?php
namespace app\model;

use \app\core\Db;
use \app\controller\MessageController;
use \app\core\Base;
use \app\core\Request;
use \app\core\Session;

class User
{
	private $UserDefaultData = [
		'name'		=> '',
		'email'		=> '',
		'passwd'		=> '',
		'level'		=> 0
	];
	private $DB;
	private $UserData;

	const LevelAdmin	= 1;
	const TABLE = TBL_PREFIX.'users';

	public function __construct(int $userid = 0)
	{
		$this->UserData 		= new \stdClass();
		$this->UserDefaultData 	= (object) $this->UserDefaultData;
		$this->DB 				= new Db(DB_HOST,DB_NAME,DB_USER,DB_PASS);

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
		$UserList = $DB->SelectSql('SELECT id, name, email, passwd, level FROM '.self::TABLE, 0, $ParamsQuery);
		foreach($UserList as &$User)
		{
			$User->admin = self::isAdmin($User->level);
		}

		return $UserList;
	}



	public function name(){ return $this->UserData->name??''; }
	public function email(){ return $this->UserData->email??''; }
	public function passwd(){ return $this->UserData->passwd??''; }
	public function level(){ return $this->UserData->level??''; }
	public function id(){ return $this->UserData->id??0; }
	public function admin($Level = null){ return self::isAdmin($Level ?? $this->UserData->level); }
	public function userdata()
	{
		return !empty((array)$this->UserData)
					? $this->UserData
					: $this->UserDefaultData;
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

		$this->UserData = $this->DB->SelectSql('SELECT * FROM '.self::TABLE.' WHERE '.$Where, 1, $Params);

		if(empty($User))
		{
			return false;
		}

		return $this;

		// foreach(array_keys((array)$this->UserDefaultData) as $Field)
		// {
		// 	$this->UserData->{$Field} 	= $User->{$Field};
		// }

		// return $this->UserData;
	}

	public function Create(array $userData)
	{
		if(empty($userData)) return false;

		$this->FillUserData($userData, 'UserDefaultData');

		$this->UserDefaultData->passwd = password_hash($this->UserDefaultData->passwd, PASSWORD_BCRYPT);

		$Status = $this->DB->Insert(self::TABLE, $this->UserDefaultData);

		if($Status !== false)
		{
			$this->Find($this->DB->InsertId);
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
			$FieldsUpdated['passwd'] = password_hash($FieldsUpdated['passwd'], PASSWORD_BCRYPT);
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

	private function emptyUser()
	{

	}

	private function FilterUpdateFields(array $userData)
	{
		$TmpFields = [];
		foreach($userData as $Field => $Value)
		{
			if(!isset($this->UserDefaultData->{$Field})) continue;

			$TmpFields[$Field] = $Value;
		}
		return $TmpFields;
	}

	private function FillUserData(array $userData, string $var = 'UserData')
	{
		foreach($this->{$var} as $Field => $Value)
		{
			if(!isset($userData[$Field])) continue;
			$this->{$var}->{$Field} = $userData[$Field];
		}

		return $this->{$var};
	}

	private static function isAdmin(int $Level)
	{
		return $Level >= self::LevelAdmin;
	}

}