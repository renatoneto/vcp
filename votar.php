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
session_start();
require('_inc_/config.php');
$vcp->notLoggedRedir();
if(!empty($_GET['id'])) {
	$vcp->vote($_GET['id']);
}
?>