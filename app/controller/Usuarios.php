<?php
namespace app\controller;

use \app\core\Views;
use \app\model\Usuario;
use \app\controller\Mensagens;
use \app\core\Request;

class Usuarios
{
	public function Lista()
	{
		Usuario::RequerLogin();
		$Usuarios = Usuario::Lista();

		Views::Carrega('main.usuarios.listar', ['Usuarios' => $Usuarios], 'Usuários');
	}

	public function Novo()
	{
		Usuario::RequerLogin();

		Views::Carrega('main.usuarios.novo', [
			'titulo' => 'Novo usuário',
			'Usuario' => (new Usuario())->Dados(),
			'FormAction' => '/usuario/novo'
		], 'Novo usuário');
	}

	public function Edita(int $codusuario = 0)
	{
		Usuario::RequerLogin();

		$Usuario = (new Usuario($codusuario))->Dados();

		if(!$Usuario->id)
		{
			Mensagens::Aviso('Usuario não encontrado.');
			return;
		}

		Views::Carrega('main.usuarios.novo', [
			'titulo' 		=> 'Editar usuário',
			'Usuario' 		=> $Usuario,
			'FormAction' 	=> '/usuario/edita/'.$Usuario->id
		]);
	}

	public function Insere()
	{
		Usuario::RequerLogin();

		$Usuario = new Usuario();
		$Status = $Usuario->Insere(Request::Input());
		if($Status)
		{
			Request::Direciona('/usuarios');
		}
		else
		{
			Mensagens::Erro('Erro salvando dados do usuário.');
			return;
		}
	}

	public function Atualiza(int $codusuario)
	{
		Usuario::RequerLogin();

		$Usuario = new Usuario($codusuario);

		if(!$Usuario->Dados()->id)
		{
			Mensagens::Aviso('Usuário não encontrado.');
			return;
		}

		$Status = $Usuario->Atualiza(Request::Input());

		if($Status)
		{
			Request::Direciona('/usuarios');
		}
		else
		{
			Mensagens::Erro('Erro salvando dados do usuário.');
			return;
		}

	}
}