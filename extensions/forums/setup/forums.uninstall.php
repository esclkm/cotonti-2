<?php
/**
 * Uninstallation handler
 *
 * @package forums
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2011-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

global $db_users;

// Remove forums columns from users table
$dbres = $db->query("SHOW COLUMNS FROM `$db_users` WHERE `Field` = 'user_postcount'");
if ($dbres->rowCount() == 1)
{
	$db->query("ALTER TABLE `$db_users` DROP COLUMN `user_postcount`");
}
$dbres->closeCursor();
