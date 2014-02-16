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
		$vcp->deleteItem($_GET['id']);
	} else {
		echo '<h3>Excluir item</h3><br />';
		$vcp->setFlash(error_9, 'error');
	}
	require('_inc_/footer.php'); 
	?>