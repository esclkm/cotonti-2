<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.tags
Tags=page.list.tpl:{LIST_COMMENTS},{LIST_COMMENTS_DISPLAY}
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

$t->assign(array(
	'LIST_COMMENTS' => cot_comments_link('page', 'c='.$c, 'page', $c),
	'LIST_COMMENTS_COUNT' => cot_comments_count('page', $c),
	'LIST_COMMENTS_DISPLAY' => cot_comments_display('page', $c, $c)
));
