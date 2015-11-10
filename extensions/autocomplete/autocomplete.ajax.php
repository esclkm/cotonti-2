<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

/**
 * Users Names file for Autocomplete
 *
 * @package autocomplete
 * @version 0.8.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$q = mb_strtolower(cot_import('q', 'G', 'TXT'));
$q = $db->prep(urldecode($q));
if (!empty($q))
{
	$res = array();
	$sql_pm_users = $db->query("SELECT `user_name` FROM $db_users WHERE `user_name` LIKE '$q%'");
	while($row = $sql_pm_users->fetch())
	{
		$res[] = $row['user_name'];
	}
	$sql_pm_users->closeCursor();
	$userlist = implode("\n", $res);
	cot_sendheaders();
}
echo $userlist;
