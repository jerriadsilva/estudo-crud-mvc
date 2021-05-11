<?php
use \app\core\Routes;
use app\core\Views;

\app\core\Session::Start();

//use \app\core\Controllers;

//use \app\controller\MainController;

Routes::get('/', 'MainController@index');

Routes::get('/produtos', 'ProdutosController@Lista');

Routes::get('/produto/edit/{id}', 'ProdutosController@Edita');
Routes::post('/produto/edit/{id}', 'ProdutosController@SalvarEdicao');

Routes::get('/produto/novo', 'ProdutosController@Novo');
Routes::post('/produto/novo', 'ProdutosController@SalvarNovo');

Routes::get('/users', 'UserController@List');
Routes::get('/user/new', 'UserController@New');
Routes::post('/user/new', 'UserController@SaveNew');


Routes::get('/user/edit/{id}', 'UserController@Edit');
Routes::post('/user/edit/{id}', 'UserController@SaveEdition');

Routes::get('/logout', 'Login@Logout');
Routes::get('/login', 'Login@LoginView');

Routes::post('/login', 'Login@DoLogin');

Routes::all('*', function(){
	Views::load('error_404');
});


// Routes::get('/', function(){
// 	echo 'Route Mains page';
// });

// Routes::get('/novo/', function(){
// 	echo 'Route New';
// });

// Routes::get('/novo/{id}/', function($Params, $QueryParams){
// 	echo 'Route new passing param value in path';
// 	var_dump($Params, $QueryParams);
// });


// Routes::get('/novo/{id}/', function($Params, $QueryParams){
// 	echo 'Route new passing param value in path';
// 	var_dump($Params, $QueryParams);
// });
