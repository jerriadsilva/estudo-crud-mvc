<?php
/*
	Variáveis setadas aqui estarão disponíveis para as views
*/

use \app\core\Request;
use \app\core\Session;
use \app\model\Usuario;
use \app\core\Formulario;

$Request = new Request();
$UsuarioLogado = (new Usuario(Session::Get('userdata')->id??0))->Dados();
$Formulario = new Formulario();