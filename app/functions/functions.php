<?php
function NormalizaPath(string $path) {
   return str_replace('\\', '/', $path);
}

function dd($Val)
{
	echo '<pre style="font-size:12px">' . print_r($Val, true) . '</pre>';
}

/* function PrintHTMLTpl(string $ContentSrc, string $BodyLayout = 'main')
{
   $ContentSrc = BASEDIR.'/app/view/'.$ContentSrc.'.php';
   $BodyLayout = BASEDIR.'/app/view/layout/'.$BodyLayout.'.php';
   if(file_exists($ContentSrc) && file_exists($BodyLayout))
   {

   }
} */