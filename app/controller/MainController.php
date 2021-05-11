<?php
namespace app\controller;

use \app\core\Controllers;
use \app\core\Session;
use \app\core\Views;
use \app\model\User;

class MainController extends Controllers
{
	public function index()
	{
		$LoggedUser = (new User(Session::Get('userdata')->id??0))->userdata();
		Views::load('main.principal', ['LoggedUser' => $LoggedUser]);
	}
}