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
require('_inc_/header.php'); ?>

	<div id="login-box">
	
	<form action="login.php" method="post">
		<label for="login">Login:</label> <input type="text" name="login" id="login" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : null; ?>" />
		<label for="senha">Senha:</label> <input type="password" name="senha" id="senha" value="<?php echo (isset($_POST['senha'])) ? $_POST['senha'] : null; ?>" />
		<input type="image" src="images/bt-logar.png" class="bt" />
	</form>
	
	</div>
	<?php
	if(isset($_POST['login'])) {
		$vcp->login();
	} else {
		$vcp->setFlash('Você precisa estar logado para utilizar o ' . $CONFIG['serverName'] . ' vCP', 'alert');
	}
	?>
	<?php require('_inc_/footer.php'); ?>