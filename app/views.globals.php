<?php
// Load global variables to all views here

use \app\core\Session;
use \app\model\Usuario;

$UsuarioLogado = (new Usuario(Session::Get('userdata')->id??0))->Dados();