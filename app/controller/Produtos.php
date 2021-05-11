<?php
namespace app\controller;

use \app\core\Views;
use \app\model\Produto;
use \app\model\Usuario;
use \app\controller\Mensagens;
use \app\core\Request;

class Produtos
{
	public function Lista()
	{
		Usuario::RequerLogin();
		$Produtos = Produto::Lista();

		Views::Carrega('main.produtos.listar', ['Produtos' => $Produtos], 'Produtos');
	}

	public function Novo()
	{
		Usuario::RequerLogin();

		Views::Carrega('main.produtos.novo', [
			'titulo' => 'Cadastrar Produto',
			'Produto' => (new Produto())->Dados(),
			'FormAction' => '/produto/novo'
		], 'Cadastrar Produto');
	}

	public function Edita(int $codproduto = 0)
	{
		Usuario::RequerLogin();
		$Produto = (new Produto($codproduto))->Dados();
		if(!$Produto->id)
		{
			Mensagens::Aviso('Produto não encontrado.');
			return;
		}

		Views::Carrega('main.produtos.novo', [
			'titulo' => 'Editar produto',
			'Produto' =>$Produto,
			'FormAction' => '/produto/edit/'.$Produto->id
		], 'Editar produto');
	}

	public function Insere()
	{
		Usuario::RequerLogin();
		$Produto = new Produto();
		$Status = $Produto->Criar(Request::Input());
		if($Status)
		{
			Request::Direciona('/produtos');
		}
		else
		{
			Mensagens::Erro('Erro cadastrando produto.');
			return;
		}
	}

	public function Atualiza(int $codproduto)
	{
		Usuario::RequerLogin();

		$Produto = new Produto($codproduto);
		if(!$Produto->Dados()->id)
		{
			Mensagens::Aviso('Produto não encontrado.');
			return;
		}

		$Status = $Produto->Update(Request::Input());

		if($Status)
		{
			Request::Direciona('/produtos');
		}
		else
		{
			Mensagens::Erro('Erro salvando informações do produto.');
			return;
		}

	}
}