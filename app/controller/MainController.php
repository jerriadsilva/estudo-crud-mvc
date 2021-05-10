<?php
namespace app\controller;

use \app\core\Controllers;
use \app\core\Views;

class MainController extends Controllers
{
	public function index()
	{
		Views::load('main.principal');
	}
}