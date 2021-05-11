<?php
// Load global variables to all views here

use \app\core\Session;
use \app\model\User;

$LoggedUser = (new User(Session::Get('userdata')->id??0))->userdata();