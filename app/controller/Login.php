<?php
namespace app\controller;

use \app\core\Request;
use \app\core\Session;
use \app\core\Views;
use \app\model\User;
use \app\core\Db;

class Login
{
	public function LoginView()
	{
		Views::load('main.login.login', null, 'Login');
	}

	public function Logout()
	{
		Session::Clear();
		Request::Redirect('/login');
	}

	public function DoLogin()
	{
		$DB = new Db(DB_HOST,DB_NAME,DB_USER,DB_PASS);
		$RequestData = Request::input();
		$User = new User();
		$UserData = $User->Find(['email' => $RequestData['email']]);

		if(!$UserData)
		{
			Request::Redirect('/login/?loginerror=1');
		}
		elseif(!password_verify($RequestData['passwd'], $User->passwd()))
		{
			Request::Redirect('/login/?loginerror=1');
		}

		Session::Set('userdata', $UserData);

		Request::Redirect('/?logged');
	}

}