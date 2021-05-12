<?php
namespace app\controller;

use \app\core\Views;
use \app\model\Usuario;
use \app\model\Produto;

class Administracao
{
	public function index()
	{
		Usuario::RequerLogin();
		$Usuarios = Usuario::Lista();
		$Produtos = Produto::Lista();
		Views::Carrega('main:admin.principal', [
			'Usuarios' => $Usuarios,
			'Produtos' => $Produtos
		], 'Administração');
	}
}