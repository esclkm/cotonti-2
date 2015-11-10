<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.delete
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
if ($cfg['trashcan']['trash_comment'])
{
	cot_trash_put('comment', $L['Comment']." #".$id." (".$row['com_author'].")", $id, $row);
}
