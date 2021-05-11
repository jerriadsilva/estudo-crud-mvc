<?php
use \app\core\Routes;
use app\core\Views;

\app\core\Session::Start();

Routes::get('/', 'Index@index');

Routes::get('/produtos', 'Produtos@Lista');

Routes::get('/produto/edit/{id}', 'Produtos@Edita');
Routes::post('/produto/edit/{id}', 'Produtos@Atualiza');

Routes::get('/produto/novo', 'Produtos@Novo');
Routes::post('/produto/novo', 'Produtos@Insere');

Routes::get('/usuarios', 'Usuarios@Lista');

Routes::get('/usuario/novo', 'Usuarios@Novo');
Routes::post('/usuario/novo', 'Usuarios@Insere');

Routes::get('/usuario/edita/{id}', 'Usuarios@Edita');
Routes::post('/usuario/edita/{id}', 'Usuarios@Atualiza');

Routes::get('/logout', 'Login@Logout');
Routes::get('/login', 'Login@Index');
Routes::post('/login', 'Login@Login');


// Carrega a view da página de erro caso não encontre nenhuma das rotas para qualquer tipo de requisição, e qualquer rota recebida
Routes::all('*', function(){
	Views::Carrega('error_404');
});
