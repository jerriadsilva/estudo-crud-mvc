<?php
namespace app\controller;

use \app\core\Views;
use \app\model\User;
use \app\controller\MessageController;
use \app\core\Request;

class UserController
{
	public function List()
	{
		User::RequireLogin();
		$UserList = User::List();

		Views::load('main.usuarios.listar', ['UserList' => $UserList], 'Usuários');
	}

	public function New()
	{
		User::RequireLogin();
		Views::load('main.usuarios.novo', [
			'titulo' => 'Novo usuário',
			'User' => (new User())->userdata(),
			'FormAction' => '/user/new'
		], 'Novo usuário');
	}

	public function Edit(int $userid = 0)
	{
		User::RequireLogin();
		$User = (new User($userid))->userdata();
		if(!$User->id)
		{
			MessageController::Message('User not found.');
			return;
		}

		Views::load('main.usuarios.novo', [
			'titulo' => 'Editar usuário',
			'User' =>$User,
			'FormAction' => '/user/edit/'.$User->id
		]);
	}

	public function SaveNew()
	{
		User::RequireLogin();
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
		User::RequireLogin();
		$User = (new User($userid))->userdata();
		if(!$User->id)
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