<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home
[END_COT_EXT]
==================== */

/**
 * Trashcan delete old
 *
 * @package trashcan
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('trashcan', 'functions');
if ($cfg['trashcan']['trash_prunedelay'] > 0)
{
	$timeago = $sys['now'] - ($cfg['trashcan']['trash_prunedelay'] * 86400);
	$sqltmp = $db->delete($db_trash, "tr_date < $timeago");
	$deleted = $db->affectedRows;
	if ($deleted > 0)
	{
		cot_log($deleted.' old item(s) removed from the trashcan, older than '.$cfg['trashcan']['trash_prunedelay'].' days', 'adm');
	}
}
