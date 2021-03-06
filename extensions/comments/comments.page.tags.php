<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
Tags=page.tpl:{PAGE_COMMENTS},{PAGE_COMMENTS_DISPLAY},{PAGE_COMMENTS_COUNT},{PAGE_COMMENTS_RSS}
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

//$rowe_urlp = empty($pag['page_alias']) ? array('c' => $pag['page_cat'], 'id' => $pag['page_id']) : array('c' => $pag['page_cat'], 'al' => $pag['page_alias']);
$t->assign(array(
	'PAGE_COMMENTS' => cot_comments_link('page', $pageurl_params, 'page', $pag['page_id'], $pag['page_cat'], $pag),
	'PAGE_COMMENTS_DISPLAY' => cot_comments_display('page', $pag['page_id'], $pag['page_cat']),
	'PAGE_COMMENTS_COUNT' => cot_comments_count('page', $pag['page_id'], $pag),
	'PAGE_COMMENTS_RSS' => cot_url('rss', 'm=comments&id=' . $pag['page_id'])
));
