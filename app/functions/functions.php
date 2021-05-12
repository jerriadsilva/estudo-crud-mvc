<?php
function NormalizaPath(string $path) {
   return str_replace('\\', '/', $path);
}

function dd($Val)
{
	echo '<pre style="font-size:12px">' . print_r($Val, true) . '</pre>';
}
use \app\core\Session;

function GeraHashForm()
{
   $DataHash = [
      $_SERVER['REQUEST_URI'],
      time(),
      uniqid()
   ];

   $Hash = sha1(implode('', $DataHash));
   Session::Set('HashForm', $Hash);
   return $Hash;
}

function VerificaHashForm($Hash)
{
   $HashSessao = Session::Get('HashForm');
   return $Hash === $HashSessao;
}

/* function PrintHTMLTpl(string $ContentSrc, string $BodyLayout = 'main')
{
   $ContentSrc = BASEDIR.'/app/view/'.$ContentSrc.'.php';
   $BodyLayout = BASEDIR.'/app/view/layout/'.$BodyLayout.'.php';
   if(file_exists($ContentSrc) && file_exists($BodyLayout))
   {

   }
} */