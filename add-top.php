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
require('_inc_/header.php');
	$vcp->levelCheck();
	?>
	<h3>Adicionar TOP</h3><br />
	<form action="add-top.php" method="post">
	<label for="nome">Nome do TOP:</label> <input type="text" name="nome" id="nome" value="<?php echo (isset($_POST['nome'])) ? $_POST['nome'] : null; ?>" />
	<label for="url">URL do TOP:</label> <input type="text" name="url" id="url" value="<?php echo (isset($_POST['url'])) ? $_POST['url'] : null; ?>" />
	<label for="minutos">Minutos para votar novamente:</label> <input type="text" name="minutos" id="minutos" value="<?php echo (isset($_POST['minutos'])) ? $_POST['minutos'] : 1440; ?>" />
	<label for="pontos">Pontos ganhos por voto:</label> <input type="text" name="pontos" id="pontos" value="<?php echo (isset($_POST['pontos'])) ? $_POST['pontos'] : null; ?>" /><br />
	<input type="image" src="images/bt-enviar.png" class="bt" />
	</form>

	<?php 
	$vcp->addTop();
	require('_inc_/footer.php'); 
	?>