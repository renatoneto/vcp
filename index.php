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
	echo '<strong class="c1">Seus pontos:</strong> ', $vcp->getPoints(), '<br /><br />';
	
	$tops = $vcp->getTops(true);
	if(!$tops) {
		$vcp->setFlash('Não há tops registrados', 'info');
	} else {
	?>
		<div id="selecionar-top">
		Top: 
		<select id="tops">
		<option value="0">Selecione</option>
		<?php echo $tops; ?>
		</select>
		</div>
		<?php $vcp->setFlash('Selecione o TOP que deseja vizualizar e vote para ganhar pontos', 'info'); ?>
	<?php
	}
	
	require('_inc_/footer.php');
	?>
