<?php
namespace app\controller;

use \app\core\Request;
use \app\core\Session;
use \app\core\Views;
use \app\model\Usuario;

class Login
{
	public function index()
	{
		Views::Carrega('main:login.login', null, 'Login');
	}

	public function Logout()
	{
		Session::Clear();
		Request::Direciona('/login');
	}

	public function Login()
	{
		$RequestData = Request::input();
		$Usuario = (new Usuario())->Busca(['email' => $RequestData['email']]);

		if(!$Usuario)
		{
			Request::Direciona('/login/?loginerror=1');
		}
		elseif(!password_verify($RequestData['passwd'], $Usuario->passwd))
		{
			Request::Direciona('/login/?loginerror=1');
		}

		Session::Set('userdata', $Usuario);

		Request::Direciona('/');
	}

}