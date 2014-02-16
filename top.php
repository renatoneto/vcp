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
	echo '<h3>Vizualizar TOP</h3>';
	if(empty($_GET['id'])) {
		$vcp->setFlash('Um ID deve ser informado', 'error');
	} else {
		$id = $_GET['id'];
		if($vcp->getTopInfos($id)) {
		
			$res = $vcp->index[0];
			$vc = (!$vcp->voteTime($res['id'], $res['minutos']) || !$vcp->voteCookie($res['id'], $res['minutos'])) ? 'Não pode votar' : 'Pode votar';
			
			if($_SESSION['v_infos']['level'] >= $CONFIG['admLevel']) {
				echo '
				<a href="edit-top.php?id=', $res['id'], '"><img src="images/edit.png" alt="Editar" title="Editar esse top" /></a>
				<a href="delete-top.php?id=', $res['id'], '"><img src="images/delete.png" alt="Excluir" title="Excluir esse top" rel="Tem certeza que deseja excluir esse top?" class="confirm" /></a>
				';
			}

			echo '<div id="top-infos">
				<strong class="c1">Nome do top:</strong> ', $res['nome'], '<br />
				<strong class="c1">Pontos ganhos:</strong> ', $res['pontos'], ' pontos<br /><br />
				<strong class="c1">Você:</strong> ', $vc, '<br />';
				if(!$vcp->voteCookie($res['id'], $res['minutos']) || !$vcp->voteTime($res['id'], $res['minutos'])) {
					$data = (count($vcp->index) > 0) ? $vcp->index[0]['data'] : $_COOKIE['t_' . $res['id']];
					echo '<strong class="c1">Próximo voto em: </strong>', date('d/m/Y H:i:s', $data);
				} else {
					echo '
					<div class="votar"><img src="images/bt-votar.png" alt="" rel="', $res['id'], '" /></div>
					';
				}
			echo '</div>';
		
		} else {
			$vcp->setFlash(error_9, 'error');
		}
	}
	require('_inc_/footer.php');
	?>