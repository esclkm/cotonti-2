<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=statistics.tags
Tags=statistics.tpl:{STATISTICS_TOTALDBCOMMENTS}
[END_COT_EXT]
==================== */

/**
 * Comments system for Feliz
 *
 * @package comments
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'functions');

$totaldbcomments = $db->countRows($db_com);
$t->assign(array(
	'STATISTICS_TOTALDBCOMMENTS' => $totaldbcomments
));
