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
class sql {

	private $pdo;
	public $index = array();
	public $r;

	function __construct() {
		try {
			$this->pdo = new PDO('mysql:host=' . HOST_IP . ';dbname=' . HOST_DB, HOST_USER, HOST_PASS);
		} catch(PDOException $e) {
			echo 'Não foi possível estabelecer conexão com o banco de dados.';
			exit;
		}
	}

	public function query($qry, $val = array()) {
		$this->r = $this->pdo->prepare($qry);
		if($this->r->execute($val)) {
			if(strpos(strtolower($qry), 'select ') !== false) {
				$ret = array();
				while($x = $this->r->fetch(PDO::FETCH_ASSOC)) {
					$ret[] = $x;
				}
				$this->index = $ret;
				return $ret;
			}
			return true;
		} else {
			return false;
		}
	}

}
?>