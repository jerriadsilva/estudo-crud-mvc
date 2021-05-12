<?php
use \app\core\Routes;
use app\core\Views;

\app\core\Session::Start();

Routes::get('/', 'Index@index');

Routes::get('/logout', 'Login@Logout');
Routes::get('/login', 'Login@Index');
Routes::post('/login', 'Login@Login');


Routes::get('/admin', 'Administracao@Index');

Routes::get('/admin/produtos', 'Produtos@Lista');

Routes::get('/admin/produto/edit/{id}', 'Produtos@Edita');
Routes::post('/admin/produto/edit/{id}', 'Produtos@Atualiza');

Routes::get('/admin/produto/novo', 'Produtos@Novo');
Routes::post('/admin/produto/novo', 'Produtos@Insere');

Routes::get('/admin/usuarios', 'Usuarios@Lista');

Routes::get('/admin/usuario/novo', 'Usuarios@Novo');
Routes::post('/admin/usuario/novo', 'Usuarios@Insere');

Routes::get('/admin/usuario/edita/{id}', 'Usuarios@Edita');
Routes::post('/admin/usuario/edita/{id}', 'Usuarios@Atualiza');



// Carrega a view da página de erro caso não encontre nenhuma das rotas para qualquer tipo de requisição, e qualquer rota recebida
Routes::all('*', function(){
	Views::Carrega('error_404');
});
