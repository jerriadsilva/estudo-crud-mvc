<?php
namespace app\core;

class Models
{
	protected $DB;
	protected function __construct()
	{
		$this->DB = new Db(DB_HOST,DB_NAME,DB_USER,DB_PASS);
	}
	protected function FilterUpdateFields(array $Data)
	{
		$TmpFields = [];
		foreach($Data as $Field => $Value)
		{
			if(!isset($this->DefaultData->{$Field})) continue;

			$TmpFields[$Field] = $Value;
		}
		return $TmpFields;
	}

	protected function FillData($Data)
	{
		$DataFilled = [];
		foreach($this->DefaultData as $FieldName => $Value)
		{
			$DataFilled[$FieldName] = $Data->{$FieldName} ?? $Value;
		}
		return (object) $DataFilled;
	}
}