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
// Login
define('LOGIN', 'SELECT `account_id`, `userid`, `user_pass`, `level` FROM `login` WHERE `userid` = ? && `user_pass` = ?');

// Bruteforce
define('BFORCE_CHECK', 'SELECT * FROM `vcp_bruteforce` WHERE `IP` = ?');
define('BFORCE_UPDATE', 'UPDATE `vcp_bruteforce` SET `data` = ?, `block` = ? WHERE `id` = ?');
define('BFORCE_INSERT', 'INSERT INTO `vcp_bruteforce` VALUES (null, ?, ?, 1)');
define('BFORCE_DELETE', 'DELETE FROM `vcp_bruteforce` WHERE id = ?');

// Pontos
define('GET_POINTS', 'SELECT `vcp_pontos` FROM `login` WHERE `account_id` = ?');
define('UPDATE_PONTOS', 'UPDATE `login` SET `vcp_pontos` = ? WHERE `account_id` = ?');

// Tops
define('ADD_TOP', 'INSERT INTO `vcp_tops` VALUES (null, ?, ?, ?, ?)');
define('EDIT_TOP', 'UPDATE `vcp_tops` SET `nome` = ?, `url` = ?, `minutos` = ?, `pontos` = ? WHERE `id` = ?');
define('GET_TOPS', 'SELECT `id`, `nome` FROM `vcp_tops` ORDER BY `id`');
define('GET_TOP', 'SELECT * FROM `vcp_tops` WHERE `id` = ?');
define('DELETE_TOP', 'DELETE FROM `vcp_tops` WHERE `id` = ?');

// Itens (top)
define('ADD_ITEM', 'INSERT INTO `vcp_itens` VALUES (null, ?, ?, ?, ?, ?)');
define('EDIT_ITEM', 'UPDATE `vcp_itens` SET `item_id` = ?, `nome` = ?, `descricao` = ?, `quantidade` = ?, `pontos` = ? WHERE `id` = ?');
define('DELETE_ITEM', 'DELETE FROM `vcp_itens` WHERE `id` = ?');
define('GET_ITENS', 'SELECT * FROM `vcp_itens` ORDER BY `pontos` DESC');
define('GET_ITEM', 'SELECT * FROM `vcp_itens` WHERE `id` = ?');
define('KAFRA_CHECK', 'SELECT `id` FROM `storage` WHERE `account_id` = ?');

// Add item
define('ADD_ITEM_KAFRA', 'INSERT INTO `storage` (`account_id`, `nameid`, `amount`, `identify`) VALUES (?, ?, ?, 1)');
define('UPDATE_ITEM_KAFRA', 'UPDATE `storage` SET `amount` = ? WHERE `id` = ?');
define('CHECK_ITEM', 'SELECT `id`, `amount` FROM `storage` WHERE `account_id` = ? && `nameid` = ? && (`amount` > 1 && `amount` <= ?)');

// Checa se está logado
define('LOGGED', 'SELECT `account_id` FROM `char` WHERE `account_id` = ? && `online` = 1');

// Votos
define('GET_DATA', 'SELECT `data` FROM `vcp_votos` WHERE `top_id` = ? && `account_id` = ?');
define('GET_IP', 'SELECT `data`, `ip` FROM `vcp_votos` WHERE `top_id` = ? && `ip` = ? && `data` > ?');
define('UPDATE_DATA', 'UPDATE `vcp_votos` SET `data` = ?, `ip` = ? WHERE `top_id` = ? && `account_id` = ?');
define('ADD_VOTE', 'INSERT INTO `vcp_votos` VALUES (null, ?, ?, ?, ?)');

?>