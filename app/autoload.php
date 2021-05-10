<?php
spl_autoload_register(function (string $class) {
   $path = str_replace('\\', '/', BASEDIR.$class) . '.php';
   if(file_exists($path))
      require  $path;
});