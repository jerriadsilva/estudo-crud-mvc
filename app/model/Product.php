<?php
namespace app\model;

use \app\core\Db;
use \app\controller\MessageController;
use \app\core\Base;
use \app\core\Request;
use \app\core\Models;

class Produtos extends Models
{
	protected $DefaultData = [
		'id'			=> null,
		'name'		=> '',
		'desc'		=> '',
		'price'		=> ''
	];

	private $ProductData;

	const TABLE = TBL_PREFIX.'products';

	public function __construct(int $productid = 0)
	{
		$this->ProductData 			= new \stdClass();
		$this->DefaultData 			= (object) $this->DefaultData;

		if($productid > 0)
		{
			$this->Find($productid);
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

		$ProductList = $DB->SelectSql('SELECT id, name, email, passwd, admin FROM '.self::TABLE, 0, $ParamsQuery);

		return $ProductList ?: [];
	}

	public function Dados()
	{
		return !empty((array)$this->ProductData)
					? $this->ProductData
					: $this->DefaultData;
	}

	public function Find($search, $params = [], $compare = 'OR')
	{
		if(isset($this->ProductData->id))
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

		$Product = $this->DB->SelectSql('SELECT * FROM '.self::TABLE.' WHERE '.$Where, 1, $Params);

		$Product = $this->FillData($Product);

		$this->ProductData = $Product;

		return $Product;
	}

	public function Criar(array $productData)
	{
		if(empty($productData)) return false;

		$productData = $this->FillData($productData);

		foreach(['name', 'desc'] as $Field)
		{
			if(empty($productData->{$Field}))
			{
				MessageController::Message('Field "'.ucfirst($Field).'" Cannot to be empty.');
				return false;
			}
		}

		$Status = $this->DB->Insert(self::TABLE, $productData);

		if($Status !== false)
		{
			Request::Redirect('/products');
		}
		return false;
	}

	public function Update(array $productData)
	{
		if(empty($productData)) return false;

		$FieldsUpdated = $this->FilterUpdateFields($productData);

		if(empty($FieldsUpdated))
		{
			MessageController::Message('Product data to update empty.');
			return false;
		}

		$Status = $this->DB->Update(self::TABLE, $this->ProductData->id, $FieldsUpdated);

		Request::Redirect('/products');
	}

	public function Delete(int $productid)
	{
		if(empty($this->ProductData)) return false;
		$Status = $this->DB->CustomQuery('DELETE FROM '.$this->Tabela.' WHERE id = ?', [$productid]);

		return $Status !== false;
	}
}