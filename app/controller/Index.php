<?php
namespace app\controller;

use \app\core\Views;
use \app\model\Produto;


class Index
{
	public function index()
	{
		$Produtos = Produto::Lista();
		Views::Carrega('main.principal', ['Produtos' => $Produtos]);
	}
}