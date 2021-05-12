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
			'get'			=> $Method === 'GET',
			'post'		=> $Method === 'POST',
			'put'			=> $Method === 'PUT',
			'delete'		=> $Method === 'DELETE',
		];
	}

	public static function Input()
	{
		$RequestInput = $_REQUEST;
		unset($RequestInput['path'], $RequestInput['hash_form']);
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
		$PostParams = $_POST;
		unset($PostParams['hash_form']);
		return $PostParams;
	}

	public static function Contem(string $busca)
	{
		$busca		= strtolower($busca);
		$ParsedUrl 	= strtolower(parse_url($_SERVER['REQUEST_URI'])['path']);

		return strpos($ParsedUrl, $busca) !== false;
	}

	public static function IniciaCom(string $busca)
	{
		$busca		= strtolower($busca);
		$ParsedUrl 	= strtolower(parse_url($_SERVER['REQUEST_URI'])['path']);

		return strpos($ParsedUrl, $busca) === 0;
	}

	public static function TerminaCom(string $busca)
	{
		$busca		= strtolower($busca);
		$ParsedUrl 	= strtolower(parse_url($_SERVER['REQUEST_URI'])['path']);

		$FinalUrl = substr($ParsedUrl, -count($busca));

		return $busca === $FinalUrl;
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