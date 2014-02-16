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
	echo '<h3>Item</h3>';
	if(empty($_GET['id'])) {
		$vcp->setFlash('Um ID deve ser informado', 'error');
	} else {
		$id = $_GET['id'];
		if($vcp->getItemInfos($id)) {
		
			$res = $vcp->index[0];
			
			if($_SESSION['v_infos']['level'] >= $CONFIG['admLevel']) {
				echo '
				<a href="edit-item.php?id=', $res['id'], '"><img src="images/edit.png" alt="Editar" title="Editar esse item" /></a>
				<a href="delete-item.php?id=', $res['id'], '"><img src="images/delete.png" alt="Excluir" title="Excluir esse item" rel="Tem certeza que deseja excluir esse item?" class="confirm" /></a>
				';
			}

			echo '<div id="item-infos">
				<img src="', $CONFIG['itemUrl'], $res['item_id'], $CONFIG['itemExt'], '" alt="" /><br />
				<strong class="c1">Item:</strong> ', $res['nome'], '<br />
				<strong class="c1">Quantidade:</strong> x', $res['quantidade'], '<br />
				<strong class="c1">Valor:</strong> ', $res['pontos'], ' pontos<br />
				<strong class="c1">Descrição:</strong> ', $res['descricao'], '<br />';
				
			if($vcp->getPoints() >= $res['pontos']) {
				echo '
				<div class="trocar"><a href="item.php?id=', $id, '&act=trocar"><img src="images/bt-trocar.png" alt="" rel="Tem certeza que deseja trocar ', $res['pontos'], ' pontos por esse item?" class="confirm" /></a></div>
				';
			}
			
			if(isset($_GET['act']) && $_GET['act'] == 'trocar') {
				$vcp->trocarItem($res['item_id'], $res['quantidade'], $res['pontos']);
			}
				
			echo '</div>';
		
		} else {
			$vcp->setFlash(error_9, 'error');
		}
	}
	require('_inc_/footer.php');
	?>