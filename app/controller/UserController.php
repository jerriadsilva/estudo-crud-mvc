<?php
namespace app\controller;

use \app\core\Controllers;
use \app\core\Views;
use \app\model\User;
use \app\controller\MessageController;
use \app\core\Request;

class UserController extends Controllers
{
	public function List()
	{
		$UserList = User::List();

		Views::load('main.usuarios.listar', ['titulo' => 'Principal', 'UserList' => $UserList], 'Principal');
	}
	public function New()
	{
		Views::load('main.usuarios.novo', [
			'titulo' => 'Novo usuário',
			'User' => (new User())->userdata(),
			'FormAction' => '/user/new'
		]);
	}

	public function Edit(int $userid = 0)
	{
		$User = new User($userid);
		if(!$User->id())
		{
			MessageController::Message('User not found.');
			return;
		}

		Views::load('main.usuarios.novo', [
			'titulo' => 'Editar usuário',
			'User' => $User->userdata(),
			'FormAction' => '/user/edit/'.$User->id()
		]);
	}

	public function SaveNew()
	{
		$User = new User();
		$Status = $User->Create(Request::Input());
		if($Status)
		{
			Request::Redirect('/');
		}
		else
		{
			MessageController::Message('Error saving user information.');
			return;
		}
	}

	public function SaveEdition(int $userid)
	{
		$User = new User($userid);
		if(!$User->id())
		{
			MessageController::Message('User not found.');
			return;
		}

		$Status = $User->Update(Request::Input());

		if($Status)
		{
			Request::Redirect('/');
		}
		else
		{
			MessageController::Message('Error saving user information.');
			return;
		}

	}
}