<?php

/**
 * Hidden groups
 *
 * @package hiddengroups
 * @version 1.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_groups;

$dbres = $db->query("SHOW COLUMNS FROM `$db_groups` WHERE `Field` = 'grp_hidden'");
if ($dbres->rowCount() == 1)
{
	$db->query("ALTER TABLE `$db_groups` DROP COLUMN `grp_hidden`");
}
$dbres->closeCursor();

$cache && $cache->db->remove('cot_groups', 'system');
