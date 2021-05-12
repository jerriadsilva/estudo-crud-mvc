<?php
/*
	Variáveis setadas aqui estarão disponíveis para as views
*/

use \app\core\Session;
use \app\model\Usuario;
use \app\core\Routes;

$Routes = new Routes();
$UsuarioLogado = (new Usuario(Session::Get('userdata')->id??0))->Dados();