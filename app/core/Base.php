<?php
namespace app\core;

class Base
{
	public static function Numeric($val)
	{
		return is_numeric($val);
	}
}