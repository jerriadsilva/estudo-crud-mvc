<?php
namespace app\controller;

use \app\core\Views;
use \app\model\Produto;
use \app\model\User;
use \app\controller\MessageController;
use \app\core\Request;

class ProdutosController
{
	public function Lista()
	{
		User::RequireLogin();
		$Produtos = Produto::Lista();

		Views::load('main.produtos.listar', ['Produtos' => $Produtos], 'Produtos');
	}

	public function Novo()
	{
		User::RequireLogin();

		Views::load('main.produtos.novo', [
			'titulo' => 'Cadastrar Produto',
			'Produto' => (new Produto())->Dados(),
			'FormAction' => '/produto/novo'
		], 'Cadastrar Produto');
	}

	public function Edita(int $idproduto = 0)
	{
		User::RequireLogin();
		$Produto = (new Produto($idproduto))->Dados();
		if(!$Produto->id)
		{
			MessageController::Message('Produto não encontrado.');
			return;
		}

		Views::load('main.produtos.novo', [
			'titulo' => 'Editar produto',
			'Produto' =>$Produto,
			'FormAction' => '/produto/edit/'.$Produto->id
		], 'Editar produto');
	}

	public function SalvarNovo()
	{
		User::RequireLogin();
		$Produto = new Produto();
		$Status = $Produto->Criar(Request::Input());
		if($Status)
		{
			Request::Redirect('/produtos');
		}
		else
		{
			MessageController::Message('Erro cadastrando produto.');
			return;
		}
	}

	public function SalvarEdicao(int $idproduto)
	{
		User::RequireLogin();

		$Produto = new Produto($idproduto);
		if(!$Produto->Dados()->id)
		{
			MessageController::Message('Produto não encontrado.');
			return;
		}

		$Status = $Produto->Update(Request::Input());

		if($Status)
		{
			Request::Redirect('/produtos');
		}
		else
		{
			MessageController::Message('Erro salvando informações do produto.');
			return;
		}

	}
}