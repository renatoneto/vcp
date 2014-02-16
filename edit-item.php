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
	if($vcp->getItemInfos($_GET['id'])) {
	$x = $vcp->index[0];
	?>
	<h3>Editar item</h3><br />
	<form action="edit-item.php?id=<?php echo $_GET['id']; ?>" method="post">
	<label for="item_id">ID do item:</label> <input type="text" name="item_id" id="item_id" value="<?php echo (isset($_POST['item_id'])) ? $_POST['item_id'] : $x['item_id']; ?>" />
	<label for="nome">Nome do item:</label> <input type="text" name="nome" id="nome" value="<?php echo (isset($_POST['nome'])) ? $_POST['nome'] : $x['nome']; ?>" />
	<label for="quantidade">Quantidade: <small class="c2">(Não aumente caso seja um equipamento ou uma arma)</small></label> <input type="text" name="quantidade" id="quantidade" value="<?php echo (isset($_POST['quantidade'])) ? $_POST['quantidade'] : $x['quantidade']; ?>" />
	<label for="pontos">Pontos:</label> <input type="text" name="pontos" id="pontos" value="<?php echo (isset($_POST['pontos'])) ? $_POST['pontos'] : $x['pontos']; ?>" />
	<label for="descricao">Descrição:</label> <textarea name="descricao" id="descricao"><?php echo (isset($_POST['descricao'])) ? $_POST['descricao'] : $x['descricao']; ?></textarea><br />
	<input type="image" src="images/bt-enviar.png" class="bt" />
	</form>

	<?php 
	$vcp->addItem($_GET['id']);
	} else {
		$vcp->setFlash(error_9, 'error');
	}
	require('_inc_/footer.php'); 
	?>