<?php
namespace app\core;

class Session
{
	public static function Start()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
	}
	
	public static function Set($key, $value)
	{
		self::Start();
		$_SESSION[$key] = $value;
	}

	public static function Get($key)
	{
		self::Start();
		return $_SESSION[$key] ?? null;
	}

	public static function Clear()
	{
		$_SESSION = [];
		session_unset();
	}

	 
}