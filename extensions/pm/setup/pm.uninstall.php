<?php
/**
 * Uninstallation handler
 *
 * @package pm
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2011-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Remove PM columns from users table
$dbres = $db->query("SHOW COLUMNS FROM `$db_users` WHERE `Field` = 'user_pmnotify'");
if ($dbres->rowCount() == 1)
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_pmnotify`");
}
$dbres->closeCursor();

$dbres = $db->query("SHOW COLUMNS FROM `$db_users` WHERE `Field` = 'user_newpm'");
if ($dbres->rowCount() == 1)
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_newpm`");
}
$dbres->closeCursor();
