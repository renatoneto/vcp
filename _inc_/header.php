<?php
/**
 * vCP
 *
 * @copyright     2010, Renato Freitas Vassão Neto (Skape)
 * @version       1.2
 * @modifiedby    Skape
 * @lastmodified  28-05-2010
 * @license       http://creativecommons.org/licenses/by-nc-nd/3.0/br/
 */
if(!file_exists('_inc_/config.php')) {
	header('Location: install/');
} elseif(file_exists('install/')) {
	unlink('install/index.php');
	rmdir('install');
}
ini_set('display_errors', 'off');
session_start();
date_default_timezone_set('America/Sao_Paulo');
require('config.php');
$vcp->notLoggedRedir();
$vcp->setCookies();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="author" content="Renato Freitas Vassão Neto (Skape)" />
<meta name="robots" content="index,follow" />
<meta http-equiv="content-language" content="pt-br" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $CONFIG['serverName']; ?> vCP - by Skape</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="favicon.png" type="image/png" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$('document').ready(function() {

	$('#tops').change(function() {
		var val = $(this).val();
		if(val > 0) {
			window.location = "top.php?id=" + val;
		}
	});
	
	$('.votar img').click(function() {
		window.open('votar.php?id='+$(this).attr('rel'), 'teste', 'height = 600, width = 800');
		document.location.reload();
	});
	
	$('.confirm').click(function() {
		if(!confirm($(this).attr('rel'))) {
			return false;
		}
	});

});
</script>

</head>
<body>
<div id="tudo">

	<div id="topo">
		<img src="images/topo.jpg" alt="" />
		<div id="menu">
			<?php 
			if($vcp->isLogged()) {
			?>
<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="itens.php">Itens</a></li>
			<?php
			if($_SESSION['v_infos']['level'] >= $CONFIG['admLevel']) {
			echo '<li><a href="add-top.php">Adicionar TOP</a></li>
			<li><a href="add-item.php">Adicionar Item</a></li>
			';
			}
			?>
<li><a href="deslogar.php">Deslogar</a></li>
			</ul>
			<?php
			}
			?>
			</div>
	</div>
	
	<div id="conteudo">
	