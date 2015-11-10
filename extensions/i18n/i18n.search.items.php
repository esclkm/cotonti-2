<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=search.page.loop
[END_COT_EXT]
==================== */

/**
 * Displays translated pages in search results
 *
 * @package i18n
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

if (!empty($row['ipage_title']))
{
	$page_url = empty($row['page_alias'])
		? cot_url('page', 'c='.$row['page_cat'].'&id='.$row['page_id'].'&l='.$row['ipage_locale'].'&highlight='.$hl)
		: cot_url('page', 'c='.$row['page_cat'].'&al='.$row['page_alias'].'&l='.$row['ipage_locale'].'&highlight='.$hl);
	$t->assign(array(
		'EXT_PR_CATEGORY' => cot_breadcrumbs(cot_i18n_build_catpath('page', $row['page_cat'], $row['ipage_locale']), false),
		'EXT_PR_TITLE' => cot_rc_link($page_url, htmlspecialchars($row['ipage_title'])),
		'EXT_PR_TEXT' => cot_clear_mark($row['ipage_text'], $words),
		'EXT_PR_TIME' => cot_date('datetime_medium', $row['ipage_date']),
		'EXT_PR_TIMESTAMP' => $row['ipage_date']
	));
}
