<?php
namespace app\core;
use \PDO;

class Db {
	protected $query;
	protected $stmt;
	private $Transaction = false;
	private $Options = 	[
									'errormode'			=> 'silent',
									'errorlogmode'		=> 'errorlog',
									'errorlogfile'		=> '',
									'logqueryerrors'	=> true,
									'logslowquery'		=> false,
									'querymaxtime'		=> 1000,
									'alowedmysqlfunctions' => ['UPPER', 'COUNT','LEAST','GREATEST','DATE','HEX','UNHEX'],
									'alowedexpressions'		=> ['ISNULL']
								];


	public $MysqlError 		= null;
	public $MysqlErrorCode 	= null;


	function __construct($Host,$DbName,$Username,$Passwd, $Opt = [], $Driver = 'mysql'){
		if(!empty($Host) && !empty($DbName) && !empty($Username))
		{
			$this->Connect($Host,$DbName,$Username,$Passwd, $Opt, $Driver);
		}
		else
			die('Precisa ser especificado Host, dbName e User');
	}

	protected function Connect($Host,$DbName,$Username,$Passwd, $Opt = [], $Driver = 'mysql')
	{
		$this->InicializaConfiguracoes($Opt);
		try
		{
			$this->Connection = new PDO("$Driver:host=$Host;dbname=$DbName", $Username, $Passwd);
			$this->SetErrorMode();
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			$this->LogError($e->getMessage());
		}
		$this->Connection->query("SET NAMES 'utf8'");
	}

	private function LogError($Error)
	{
		if($this->Options['errorlogmode'] === 'file' && !empty($this->Options['errorlogfile']))
		{
			error_log($Error, 3, $this->Options['errorlogfile']);
		}
		else error_log($Error);
	}

	private function SetErrorMode()
	{
		$ErrorModeList = [
									'silent' 	=> PDO::ERRMODE_SILENT,
									'exception' => PDO::ERRMODE_EXCEPTION
								];
		$this->Connection->setAttribute(PDO::ATTR_ERRMODE, $ErrorModeList[$this->Options['errormode']] ?? $ErrorModeList['silent']);
	}

	private function InicializaConfiguracoes($Opt)
	{
		if(empty($Opt) || !is_array($Opt)) return;
		foreach($Opt as $keyOpt => $valueOpt)
		{
			$this->Options[strtolower($keyOpt)] = is_string($valueOpt) ? strtolower($valueOpt) : $valueOpt;
		}

		if(!empty($this->Options['alowedmysqlfunctions']))
		{
			foreach($this->Options['alowedmysqlfunctions'] as $k => $Fn)
			{
				$this->Options['alowedmysqlfunctions'][$k] .= '(';
			}
		}
	}

	public function Start_Transaction()
	{
		$this->Connection->beginTransaction();
		$this->Connection->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
	}

	public function Commit()
	{
		if(!$this->Connection->inTransaction()) return;
		$Commit = $this->Connection->commit();
		$this->Connection->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
		return $Commit;
	}

	public function Rollback()
	{
		if(!$this->Connection->inTransaction()) return;
		$this->Connection->rollBack();
		$this->Connection->setAttribute(PDO::ATTR_AUTOCOMMIT, true);
	}

	private function BindValues($Params)
	{
		if(empty($Params)) return false;
		foreach($Params as $key => $value)
		{
			$this->stmt->bindValue($key+1, $value);
		}
	}

	private function CheckAndSetError()
	{
		$Error = $this->stmt->errorInfo();
		if(!empty($Error[2]))
		{
			$this->MysqlError = $Error[2];
			$this->MysqlErrorCode = $Error[1];//

			if($this->Options['logqueryerrors'])
			{
				$this->LogError('['.($this->ErrorCode??'').'] '.$this->MysqlError);
			}
		}
		$this->CheckSlowQueryLog();
	}

	private function PrepareQuery($strQuery, $Params)
	{
		$this->stmt = $this->Connection->prepare($strQuery);
		$this->BindValues($Params);
		$this->CheckAndSetError();
	}

	private function IsNumeric($x)
	{
		return is_numeric($x) && !is_nan($x) && is_finite($x);
	}

	private function InitializeQuery()
	{
		$this->Rows = 0;
		$this->ErrorMsg = null;
		$this->ErrorCode = null;
		$this->InsertId = null;
		$this->MysqlError = null;
		$this->MysqlErrorCode = null;
	}

	private function SearchPosParam($strQuery, $Position=0)
	{
		$UPos = 0;
		$Pos = 0;
		$PosParam = 0;
		while(($Pos = strpos($strQuery, '?', $UPos)) !== false)
		{
			var_dump([$Pos]);
			$UPos = $Pos;
			// if(!isset($Params[$PosParam]))
			// 	$ValorFinal = 'NULL';
			// elseif($this->numerico($Params[$PosParam]))
			// 	$ValorFinal = floatval($Params[$PosParam]);
			// elseif($this->MysqlFunction($Params[$PosParam]))
			// 	$ValorFinal = $Params[$PosParam];
			// else
			// 	$ValorFinal = "'{$Params[$PosParam]}'";

			// $strQuery = substr_replace($strQuery, $ValorFinal, $Pos, 1);

			// $PosParam++;
		}
	}

	private function CheckSlowQueryLog()
	{
		if($this->Options['logslowquery'] && $this->Options['querymaxtime'] && $this->QueryTime > $this->Options['querymaxtime'])
		{
			$Query = $this->ParseSql($this->TmpStrQuery, $this->TmpParams);
			$this->LogError('Slow query ['.$this->QueryTime.'] '.$Query);
		}
	}

	public function NotEscapeFields()
	{
		$this->NotEscapedFieldList = [];
		$this->NotEscapedFieldsEnable = false;
		if(!func_num_args()) return;
		$Fields = func_get_args();
		foreach($Fields as $KField => $Field)
		{
			$this->NotEscapedFieldList[$KField] = $Field;
		}
		$this->NotEscapedFieldsEnable = true;
	}

	private function VerificaFuncoesMysql(&$strQuery, &$Params)
	{
		if(empty($Params)) return;
		foreach($Params as $Key => $Param)
		{
			$filteredItems = array_filter($this->Options['alowedmysqlfunctions'], function($elem) use($Param){
				return strpos($Param, $elem) !== false;
		 	});
//		  var_dump($filteredItems);
		  continue;
			$FnFound = false;
			foreach($this->Options['alowedmysqlfunctions'] as $Fn)
			{

			}
			$PosS = array_search($Param.'(', $this->Options['alowedmysqlfunctions']);

			var_dump([$Param, $PosS]);

			if($PosS !== false)
			{
				var_dump([$Key, $Param, $this->SearchPosParam($strQuery, $Key)]);
			}
		}
		return true;
	}

	public function PrepareAndExecuteQuery($strQuery, $Params)
	{
		$this->TmpStrQuery = $strQuery;
		$this->TmpParams = $Params;

		$InitialTime = microtime(true);
		$this->VerificaFuncoesMysql($strQuery, $Params);

		$this->PrepareQuery($strQuery, $Params);
		$Res = $this->stmt->execute();

		$this->QueryTime = microtime(true) - $InitialTime;

		$this->CheckAndSetError();
		$this->Rows = $this->stmt->rowCount();
		return $Res;
	}

	public function FetchAll($AsArray = false)
	{
		return $this->stmt->fetchAll($AsArray ? PDO::FETCH_ASSOC : PDO::FETCH_OBJ);
	}

	public function Fetch($AsArray = false)
	{
		return $this->stmt->fetch($AsArray ? PDO::FETCH_ASSOC : PDO::FETCH_OBJ);
	}

	public function ParseSql($strQuery, $Params = [])
	{
		if(empty($strQuery)) return '';
		if(empty($Params)) $Params = [];

		$UPos = 0;
		$Pos = 0;
		$PosParam = 0;
		while(($Pos = strpos($strQuery, '?', $UPos)) !== false)
		{
			if(!isset($Params[$PosParam]))
				$FinalValue = 'NULL';
			elseif($this->IsNumeric($Params[$PosParam]))
				$FinalValue = floatval($Params[$PosParam]);
			else
				$FinalValue = '\'' . addslashes($Params[$PosParam]) . '\'';

			$strQuery = substr_replace($strQuery, $FinalValue, $Pos, 1);

			$PosParam++;
		}
		return $strQuery;
	}

	public function CustomQuery($strQuery, $Params = false, $DumpSql = false)
	{
		$this->InitializeQuery();

		if(!empty($Params))
		{
			foreach($Params as $key => $value)
			{
				$Params[$key] = $value;
			}
		}

		if($DumpSql)
		{
			var_dump($this->ParseSql($strQuery, $Params));
			return;
		}

		$Response = $this->PrepareAndExecuteQuery($strQuery, $Params);

		return $Response;
	}

	public function SelectSql($strQuery, $ReturnType = 0, $Params = false, $DumpSql = false)
	{
		$this->InitializeQuery();

		$ReturnType = $ReturnType === true ? 1 : $ReturnType;

		if(!empty($Params))
		{
			foreach($Params as $key => $value)
			{
				$Params[$key] = $value;
			}
		}

		if($DumpSql)
		{
			var_dump($this->ParseSql($strQuery, $Params));
			return;
		}

		$Response = $this->PrepareAndExecuteQuery($strQuery, $Params);

		if(!$Response) return false;

		switch($ReturnType)
		{
			case 1	: 	$this->Rows = $this->Rows > 0 ? 1 : 0;
							$Response = $this->Fetch();
							break;
			case 2	: $Response = $this->stmt;break;
			default	: $Response = $this->FetchAll();
		}
		return $Response;
	}

	public function Insert($Table, $Data, $DuplicateKeyStatementData = null, $Ignore = false, $DumpSql = false)
	{
		$this->InitializeQuery();

		$Data = (array) $Data;

		$ValueMask = implode(',', array_fill(0, count($Data), '?'));

		$FieldArray = implode(',', array_keys($Data));

		$strQuery = 'INSERT '.($Ignore ? 'IGNORE' : '').' INTO '.$Table. ' ('.$FieldArray.') VALUES('.$ValueMask.')';

		$Params = array_values($Data);

		if(isset($DuplicateKeyStatementData))
		{
			if(is_array($DuplicateKeyStatementData) || is_object($DuplicateKeyStatementData))
			{
				$strQuery .= ' ON DUPLICATE KEY UPDATE ';
				foreach($DuplicateKeyStatementData as $DuplicateFieldName => $DuplicateFieldValue)
				{
					$strQuery .= $DuplicateFieldName . ' = ?';
					$Params[] = $DuplicateFieldValue;
				}
			}
			elseif(is_string($DuplicateKeyStatementData))
			{
				$strQuery .= $DuplicateKeyStatementData;
			}
		}

		if($DumpSql)
		{
			var_dump($this->ParseSql($strQuery, $Params));
			return;
		}

		$Status = $this->PrepareAndExecuteQuery($strQuery, $Params);

		$this->InsertId = (int) $this->Connection->lastInsertId();

		return $Status;
	}

	public function Update($Table, $Id, $Data, $DumpSql = false)
	{
		$this->InitializeQuery();

		$Data = (array) $Data;

		$Params = [];

		$strQuery = 'UPDATE '.$Table.' SET ';

		$queryValues = [];

		foreach($Data as $DataFieldName => $DataFieldValue)
		{
			$queryValues[] = $DataFieldName . ' = ?';
			$Params[] = $DataFieldValue;
		}

		$strQuery .= implode(', ', $queryValues);
		$strQuery .= ' WHERE ';

		if($this->IsNumeric($Id))
		{
			$strQuery .= ' id = ?';
			$Params[] = $Id;
		}
		elseif(is_array($Id))
		{

			$strQuery .= !empty($Id[2])
								? $Id[0] . ' '. $Id[2].' ?'
								: $Id[0] . ' = ?';
			$Params[] = $Id[1];
		}
		else
		{
			$strQuery .= $Id;
		}

		if($DumpSql)
		{
			var_dump($this->ParseSql($strQuery, $Params));
			return;
		}

		$Status = $this->PrepareAndExecuteQuery($strQuery, $Params);

		return $Status;
	}
};