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
function __autoload($c) { require_once('_inc_/classes/' . $c . '.class.php'); }
class vCP extends sql {

	public $icons = array();
	private $config = array();
	private $flash;

	function __construct($c) {
		parent::__construct();
		$this->config = $c;
		
		$this->icons['alert'] = '<img src="images/alert.png" class="icone" alt="" />';
		$this->icons['error'] = '<img src="images/error.png" class="icone" alt="" />';
		$this->icons['info'] = '<img src="images/info.png" class="icone" alt="" />';
		$this->icons['ok'] = '<img src="images/ok.png" class="icone" alt="" />';
	}
	
	// Seta uma mensagem para aparecer dentro da div de informações
	public function setFlash($msg, $icon = false) {
		if($icon) {
			$msg = $this->icons[$icon] . $msg;
		}
		$this->flash = $msg;
	}
	
	// Exibe a mensagem caso haja uma
	public function flash() {
		if(!empty($this->flash)) echo "\n\t" . '<div class="info">', $this->flash, '</div>' . "\n";
	}
	
	// Seta o cookie de cada top para evitar votos
	public function setCookies() {
		$tops = $this->getTops();
		for($i = 0, $c = count($tops); $i < $c; $i++) {
			$topname = 't_' . $tops[$i]['id'];
			if(!isset($_COOKIE[$topname]) || $_COOKIE[$topname] <= 0) {
				setcookie($topname, 0, strtotime('+1 year', time()));
			}
		}
		//print_r($_COOKIE);
	}
	
	// Retorna true se estiver logado e false caso contrário
	public function isLogged() {
		return (isset($_SESSION['v_logged'])) ? true : false;
	}

	// Redireciona para página de login caso não esteja logado
	public function notLoggedRedir() {
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		if(!$this->isLogged() && $uri[count($uri) - 1] != 'login.php') {
			$this->redirect('login.php');
			exit;
		}
	}
	
	// Efetua login
	public function login() {
	
		$login = trim($_POST['login']);
		$senha = trim($_POST['senha']);
		
		if(empty($login) || empty($senha)) {
			$this->setFlash(error_1, 'error');
		} else {

			$bf = array();
			if($this->query(BFORCE_CHECK, array($_SERVER['REMOTE_ADDR']))) {
				$bf = $this->index[0];
			}
			$bfs = count($bf);

			if($bfs > 0 && $bf['block'] >= $this->config['bfTimes'] && $bf['data'] > time()) {
				$this->setFlash(error_2, 'error');
			} else {
				if($bfs > 0 && $bf['data'] < time()) {
					$bfs = 0;
					$this->query(BFORCE_DELETE, array($bf['id']));
				}
				$r = $this->query(LOGIN, array($login, $senha));
				if($r) {
					if($bfs > 0) $this->query(BFORCE_DELETE, array($bf['id']));
					$_SESSION['v_logged'] = true;
					$_SESSION['v_infos'] = $this->index[0];
					$this->redirect('index.php');
				} else {
					$this->setFlash(error_3, 'error');
					if($bfs > 0) {
						$this->query(BFORCE_UPDATE, array(strtotime('+' . $this->config['bfTime'] . ' minutes', time()), ++$bf['block'], $bf['id']));
					} else {
						$this->query(BFORCE_INSERT, array($_SERVER['REMOTE_ADDR'], strtotime('+' . $this->config['bfTime'] . ' minutes', time())));
					}
				}
			}
		}
	}
	
	// Adiciona ou edita um top
	public function addTop($id = false) {
		if(isset($_POST['nome'])) {
			$nome = trim($_POST['nome']);
			$url = trim($_POST['url']);
			$minutos = trim($_POST['minutos']);
			$pontos = trim($_POST['pontos']);
			
			if(empty($nome) || empty($url) || empty($minutos) || empty($pontos)) {
				$this->setFlash(error_4, 'error');
			} else {
			
				if(is_numeric($id)) {
					$ar = array($nome, $url, $minutos, $pontos, $id);
					$msg1 = sucess_1;
					$msg2 = error_5;
				} else {
					$ar = array($nome, $url, $minutos, $pontos);
					$msg1 = sucess_2;
					$msg2 = error_6;
				}
			
				if($this->query(((!is_numeric($id)) ? ADD_TOP : EDIT_TOP), $ar)) {
					$this->setFlash($msg1, 'ok');
					if(is_numeric($id)) $this->redirect('top.php?id=' . $id, 2);
				} else {
					$this->setFlash($msg2, 'error');
				}
			}
		}
	}
	
	// Deleta um top
	public function deleteTop($id) {
		if($this->query(DELETE_TOP, array($id))) {
			$this->redirect('index.php');
		} else {
			$this->setFlash(error_7, 'error');
		}
	}
	
	// Busca todos os tops cadastrados, se passado true como primeiro parâmetro ele retorna em formato de select: <option...
	public function getTops($sel = false) {
		if($this->query(GET_TOPS)) {
			if($sel) {
				$return = null;
				for($i = 0, $c = count($this->index); $i < $c; $i++) {
					$return .= '<option value="' . $this->index[$i]['id'] . '">' . $this->index[$i]['nome'] . '</option>' . "\n";
				}
				return $return;
			} else {
				return $this->index;
			}
		} else {
			return false;
		}
	}
	
	// Pega as informações do top
	public function getTopInfos($id) {
		return $this->query(GET_TOP, array($id));
	}
	
	// Checa se a pessoa pode votar nesse top através da tabela
	public function voteTime($id, $time) {
		if($this->query(GET_DATA, array($id, $_SESSION['v_infos']['account_id']))) {
			if($this->index[0]['data'] > time()) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	
	// Checa se a pessoa pode votar nesse top através do cookie
	public function voteCookie($id, $time) {
		$ret = $this->query(GET_IP, array($id, $_SERVER['REMOTE_ADDR'], time()));
		if($_COOKIE['t_' . $id] > time() || (count($ret) > 0 && $ret[0]['data'] != $_COOKIE['t_' . $id])) {
			return false;
		} else {
			return true;
		}
	}
	
	// Insere os pontos na conta e redireciona para a url do top
	public function vote($id) {
		if($this->getTopInfos($id)) {
			$x = $this->index[0];
			if(!$this->voteCookie($id, $x['minutos']) || !$this->voteTime($id, $x['minutos'])) {
				echo error_8;
				exit;
			}

			$data = strtotime('+' . $x['minutos'] . ' minutes', time());			
			$v = false;
			$accid = $_SESSION['v_infos']['account_id'];
			$ip = $_SERVER['REMOTE_ADDR'];
			if(count($this->index) > 0) {
				$v = $this->query(UPDATE_DATA, array($data, $ip, $id, $accid));
			} else {
				$v = $this->query(ADD_VOTE, array($id, $data, $accid, $ip));
			}
			setcookie('t_' . $id, $data, strtotime('+1 year', time()));

			if($v) {
				$this->query(UPDATE_PONTOS, array($this->getPoints() + $x['pontos'], $accid));
				$this->redirect($x['url']);
			}
			
		} else {
			echo error_9;
		}
	}
	
	// Retorna a quantidade de pontos que a conta logada tem
	public function getPoints() {
		$this->query(GET_POINTS, array($_SESSION['v_infos']['account_id']));
		return $this->index[0]['vcp_pontos'];
	}
	
	// Checa o level e redireciona caso não tenha suficiente para acessar a página
	public function levelCheck() {
		if($_SESSION['v_infos']['level'] < $this->config['admLevel']) {
			$this->redirect('index.php');
		}
	}

	// Envia para o endereço informado
	public function redirect($to, $tempo = 0) {
		echo '<meta http-equiv="refresh" content="', $tempo, '; url=', $to, '">';
	}
	
	// Adiciona ou edita um item
	public function additem($id = false) {
		if(isset($_POST['item_id'])) {
			$item_id = trim($_POST['item_id']);
			$nome = trim($_POST['nome']);
			$quantidade = (!empty($_POST['quantidade'])) ? (int)trim($_POST['quantidade']) : 1;
			$pontos = trim($_POST['pontos']);
			$descricao = strip_tags(trim($_POST['descricao']));
			
			if(empty($item_id) || empty($nome) || empty($pontos)) {
				$this->setFlash(error_10, 'error');
			} else {
			
				if(is_numeric($id)) {
					$ar = array($item_id, $nome, $descricao, $quantidade, $pontos, $id);
					$msg1 = sucess_3;
					$msg2 = error_11;
				} else {
					$ar = array($item_id, $nome, $descricao, $quantidade, $pontos);
					$msg1 = sucess_4;
					$msg2 = error_12;
				}
			
				if($this->query(((!is_numeric($id)) ? ADD_ITEM : EDIT_ITEM), $ar)) {
					$this->setFlash($msg1, 'ok');
					if(is_numeric($id)) $this->redirect('item.php?id=' . $id, 2);
				} else {
					$this->setFlash($msg2, 'error');
				}
			}
		}
	}
	
	// Deleta um item
	public function deleteItem($id) {
		if($this->query(DELETE_ITEM, array($id))) {
			$this->redirect('itens.php');
		} else {
			$this->setFlash(error_7, 'error');
		}
	}

	// Pega as informações do item
	public function getItemInfos($id) {
		return $this->query(GET_ITEM, array($id));
	}
	
	// Busca todos os itens cadastrados
	public function getItens() {
		$this->query(GET_ITENS);
	}
	
	// Faz a troca de pontos por item
	public function trocarItem($item_id, $amount, $pontos) {
		$accid = $_SESSION['v_infos']['account_id'];
		if($pontos > $this->getPoints()) {
			$this->setFlash(error_13, 'error');
		} else {
			$kc = $this->query(KAFRA_CHECK, array($accid));
			if(count($kc) >= $this->config['kafra']) {
				$this->setFlash(error_14, 'error');
			} else {
				$logged = $this->query(LOGGED, array($accid));
				if(count($this->index) > 0) {
					$this->setFlash(error_15, 'error');
				} else {
					$pontos = $this->getPoints() - $pontos;
					if($this->query(UPDATE_PONTOS, array($pontos, $accid))) {
						$qnt = $this->query(CHECK_ITEM, array($accid, $item_id, 30000 - $amount));
						if(count($qnt) == 0) {
							if($this->query(ADD_ITEM_KAFRA, array($accid, $item_id, $amount))) {
								$this->setFlash(sucess_5, 'ok');
							}
						} else {
							$am = $qnt[0]['amount'] + $amount;
							if($this->query(UPDATE_ITEM_KAFRA, array($am, $qnt[0]['id']))) {
								$this->setFlash(sucess_5, 'ok');
							}
						}
					} else {
						$this->setFlash(error_16, 'error');
					}
				}
			}
		}
	}


#	
}
?>