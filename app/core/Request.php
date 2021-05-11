<?php
namespace app\core;

class Request
{
	private static function RequestMethod()
	{
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

	public static function Direciona($Uri)
	{
		header('Location: '.$Uri);
		die();
	}

	public static function Method()
	{
		$Method = self::RequestMethod();
		return (object) [
			'get'		=> $Method === 'GET',
			'post'		=> $Method === 'POST',
			'put'		=> $Method === 'PUT',
			'delete'	=> $Method === 'DELETE',
		];
	}

	public static function Input()
	{
		$RequestInput = $_REQUEST;
		unset($RequestInput['path']);
		return $RequestInput;
	}

	public static function GetParams()
	{
		$GetParams = $_GET??[];
		unset($GetParams['path']);
		return $GetParams;
	}

	public static function PostParams()
	{
		return $_POST;
	}

	public static function get()
	{
		return self::Method()->get;
	}

	public static function post()
	{
		return self::Method()->post;
	}

	public static function put()
	{
		return self::Method()->put;
	}

	public static function delete()
	{
		return self::Method()->delete;
	}
}