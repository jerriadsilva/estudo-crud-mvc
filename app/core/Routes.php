<?php
namespace app\core;

use app\controller\Mensagens;
use \app\core\Controllers;
use \app\core\Request;

class Routes
{
	private static $Method;
	private static $ParamsOnPath = [];
	private static $QueryParams = [];

	public static function Method()
	{
		self::$Method = strtoupper($_SERVER['REQUEST_METHOD']);
		return (object) [
			'get'	=> self::$Method === 'GET',
			'post'	=> self::$Method === 'POST',
			'put'	=> self::$Method === 'PUT',
			'delete'	=> self::$Method === 'DELETE',
		];
	}

	public static function PathInUriRequest($path)
	{
		$ParsedUrl 	= parse_url($_SERVER['REQUEST_URI']);
		$UrlRequest = explode('/', strtolower($ParsedUrl['path']));
		$PathItems 	= explode('/', $path);
		$PathItems 	= array_values(array_filter($PathItems));
		$UrlRequest = array_values(array_filter($UrlRequest));

		if(count($PathItems) !== count($UrlRequest))
		{
			return false;
		}

		foreach ($PathItems as $key_path => $value_path)
		{
			if($value_path !== $UrlRequest[$key_path])
			{
				if(preg_match('/\{(\w+)\}/',$value_path, $match))
				{
					self::$ParamsOnPath[$match[1]] = $UrlRequest[$key_path];
					continue;
				}
				else
				{
					return false;
				}
			}
		}

		if(!empty($ParsedUrl['query']))
		{
			parse_str($ParsedUrl['query'], self::$QueryParams);
		}

		return true;
	}

	public static function NormalizaPath($path)
	{
		if(substr($path, -1, 1) !== '/') $path .= '/';

		return $path;
	}

	private static function ExecuteRoute($path, $controllerOrCallback)
	{
		if($path !== '*')
			$path = self::NormalizaPath(strtolower($path));

		if($path === '*' || self::PathInUriRequest($path))
		{
			if(is_string($controllerOrCallback))
			{
				Controllers::ExecutaController($controllerOrCallback, self::$ParamsOnPath, self::$QueryParams);
			}
			elseif(is_callable($controllerOrCallback))
			{
				$controllerOrCallback(self::$ParamsOnPath, self::$QueryParams);
			}
			else
			{
				die('Controller ou callback inválido');
			}
		}
	}

	public static function get($path, $controllerOrCallback)
	{
		if(!Request::get()) return;

		self::ExecuteRoute($path, $controllerOrCallback);
	}

	public static function post($path, $controllerOrCallback)
	{
		if(!Request::post()) return;

		self::ExecuteRoute($path, $controllerOrCallback);
	}

	public static function all($path, $controllerOrCallback)
	{
		self::ExecuteRoute($path, $controllerOrCallback);
	}
}