<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.edit.update.delete
[END_COT_EXT]
==================== */

/**
 * Trashcan delete page
 *
 * @package trashcan
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('trashcan', 'functions');
if ($cfg['trashcan']['trash_user'])
{
	cot_trash_put('user', $L['User']." #".$id." ".$row['user_name'], $id, $row1);
}
