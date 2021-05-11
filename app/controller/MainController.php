<?php
namespace app\controller;

use \app\core\Views;
use \app\model\Produto;


class MainController
{
	public function index()
	{
		$Produtos = Produto::Lista();
		Views::load('main.principal', ['Produtos' => $Produtos]);
	}
}