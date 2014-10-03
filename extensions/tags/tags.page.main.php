<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.main
[END_COT_EXT]
==================== */

/**
 * Generates page keywords
 *
 * @package tags
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['pages'])
{
	require_once cot_incfile('tags', 'module');
	// I18n or not i18n
	if (cot_extension_active('i18n') && $i18n_enabled && $i18n_notmain)
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$item_id = $pag['page_id'];
	$tags = cot_tag_list($item_id, 'pages', $tags_extra);
	$tag_keywords = implode(', ', $tags);
	if (!empty($tag_keywords) && empty($pag['page_keywords']))
	{
		$out['keywords'] = $tag_keywords;
	}
}
