<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=polls.viewall.tags
Tags=polls.tpl:{POLLS_COMMENTS}
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
	'POLLS_COMMENTS' => cot_comments_link('polls', 'id='.$row['poll_id'], 'polls', $row['poll_id']),
	'POLLS_COMMENTS_COUNT' => cot_comments_count('polls', $row['poll_id'])
));
