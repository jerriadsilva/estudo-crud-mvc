<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=SITE_NAME.(!empty($PageTitle) ? ' - '.$PageTitle : '');?></title>
	<script src="/js/jquery-3.5.1.slim.min.js"></script>
	<script src="/js/bootstrap-4.6.js"></script>
	<!-- <link rel="stylesheet" href="/css/bootstrap-4.6.css"> -->
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php
if($Request::IniciaCom('/admin'))
	include(__DIR__.'/navbar-admin.php');
else
	include(__DIR__.'/navbar-guest.php');
?>
<div role="main" class="justify-content-center">
	<?php include($Conteudo) ?>
</div>
</body>
</html>