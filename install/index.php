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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="author" content="Renato Freitas Vassão Neto (Skape)" />
<meta name="robots" content="index,follow" />
<meta http-equiv="content-language" content="pt-br" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Instalação vCP - by Skape</title>
<link rel="stylesheet" href="../styles/style.css" type="text/css" media="screen" />
</head>
<body>
<div id="install">
	<h3>Instalação vCP</h3><br />
	<form action="" method="post">
	<fieldset>
	<legend>Banco de dados</legend>
	<label for="ip">IP:</label> <input type="text" name="ip" id="ip" value="<?php echo (isset($_POST['ip'])) ? $_POST['ip'] : 'localhost'; ?>" />
	<label for="usuario">Usuário:</label> <input type="text" name="usuario" id="usuario" value="<?php echo (isset($_POST['usuario'])) ? $_POST['usuario'] : null; ?>" />
	<label for="senha">Senha:</label> <input type="text" name="senha" id="senha" value="<?php echo (isset($_POST['senha'])) ? $_POST['senha'] : null; ?>" />
	<label for="db">Database:</label> <input type="text" name="db" id="db" value="<?php echo (isset($_POST['db'])) ? $_POST['db'] : 'ragnarok'; ?>" />
	</fieldset>
	<fieldset>
	<legend>Configurações vCP</legend>
	<label for="servidor">Nome do servidor:</label> <input type="text" name="servidor" id="servidor" value="<?php echo (isset($_POST['servidor'])) ? $_POST['servidor'] : null; ?>" />
	<label for="kafra">Kafra:</label> <input type="text" name="kafra" id="kafra" value="<?php echo (isset($_POST['kafra'])) ? $_POST['kafra'] : 600; ?>" />
	<label for="adm">Adm Level:</label> <input type="text" name="adm" id="adm" value="<?php echo (isset($_POST['adm'])) ? $_POST['adm'] : 99; ?>" />
	</fieldset>
	<input type="image" src="../images/bt-enviar.png" class="bt" />
	</form><br />
	<?php
	ini_set('display_errors', 'off');
	if(isset($_POST['ip'])) {
	
		$ip = $_POST['ip'];
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
		$db = $_POST['db'];
		$servidor = (!empty($_POST['servidor'])) ? $_POST['servidor'] : 'Ragnarok';
		$kafra = (!empty($_POST['kafra'])) ? (int)$_POST['kafra'] : 600;
		$adm = (!empty($_POST['adm'])) ? (int)$_POST['adm'] : 99;
		
		if(empty($ip) || empty($usuario) || empty($db)) {
			echo 'Todos os campos do Banco de dados devem ser preenchidos.';
		} else {
		
			if(mysql_connect($ip, $usuario, $senha)) {
			
				if(mysql_select_db($db)) {
				
					$q1 = mysql_query("ALTER TABLE `login` ADD `vcp_pontos` INT NOT NULL DEFAULT '0'");
					$q2 = mysql_query("CREATE TABLE IF NOT EXISTS `vcp_tops` (`id` int(11) NOT NULL AUTO_INCREMENT, `nome` varchar(40) NOT NULL, `url` varchar(100) NOT NULL, `minutos` smallint(8) NOT NULL, `pontos` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
					$q3 = mysql_query("CREATE TABLE IF NOT EXISTS `vcp_bruteforce` (`id` int(11) NOT NULL AUTO_INCREMENT, `IP` varchar(20) NOT NULL DEFAULT '', `data` int(11) NOT NULL, `block` tinyint(1) NOT NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
					$q4 = mysql_query("CREATE TABLE IF NOT EXISTS `vcp_votos` (`id` int(11) NOT NULL AUTO_INCREMENT, `top_id` int(11) NOT NULL, `data` int(11) NOT NULL, `account_id` int(11) NOT NULL, `ip` varchar(20) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
					$q5 = mysql_query("CREATE TABLE IF NOT EXISTS `vcp_itens` (`id` int(11) NOT NULL AUTO_INCREMENT, `item_id` int(11) NOT NULL, `nome` varchar(50) NOT NULL, `descricao` text NOT NULL, `quantidade` int(11) NOT NULL, `pontos` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
				
					if(!$q1) {
						echo 'Erro ao alterar a tabela login, verifique se o campo vcp_pontos já não existe';
					} elseif(!$q2 || !$q3 || !$q4 || !$q5) {
						echo 'Erro ao criar tabelas.';
					} else {
				
$config = '<?php
/**
 * vCP
 *
 * @copyright     2010, Renato Freitas Vassão Neto (Skape)
 * @version       1.0
 * @modifiedby    Skape
 * @lastmodified  28-05-2010
 * @license       http://creativecommons.org/licenses/by-nc-nd/3.0/br/
 */
//= Banco de dados ==========================================================
define("HOST_IP", "' . $ip . '");				// IP
define("HOST_USER", "' . $usuario . '");				// Usuário
define("HOST_PASS", "' . $senha . '");					// Senha
define("HOST_DB", "' . $db . '");				// Noma da database do servidor		
//===========================================================================
$CONFIG["serverName"] = "' . $servidor . '";		// Nome do servidor
$CONFIG["kafra"] = ' . $kafra . ';						// Capacidade de Kafra (para poder entregar o item quando comprado)
$CONFIG["admLevel"] = ' . $adm . ';					// Level para ter acesso ao menu de adm
//===========================================================================
$CONFIG["bfTimes"] = 5;						// Erros que deve cometer no login antes de ser bloqueado
$CONFIG["bfTime"] = 10;						// Tempo que fica bloqueado (em minutos)
$CONFIG["itemUrl"] = "http://www.ragnadb.com.br/img/small/";	// URL das imagens dos itens
$CONFIG["itemExt"] = ".gif";	// extensão das imagens dos itens

require("query.php");
require("text.php");
require("classes/vcp.class.php");
$vcp = new vCP($CONFIG);
?>';
					
						if($fp = fopen('../_inc_/config.php', 'w')) {
							if(fwrite($fp, $config) === false) {
								echo 'Erro ao escrever arquivo de configuração';
							} else {
								echo 'vCP configurado com sucesso.<br />
								Você será redirecionado em 5 segundos...
								<meta http-equiv="refresh" content="5; url=../index.php">';
							}
							fclose($fp);
						} else {
							echo 'Erro ao criar arquivo de configuração';
						}
					}
				
				} else {
					echo 'Não foi possível selecionar o banco de dados, verifique os dados informados.';
				}
			
			} else {
				echo 'Não foi possível estabelecer conexão com o banco de dados, verifique os dados informados.';
			}
		}
	}
	?>
</div>	
</body>
</html>