<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.delete.done,i18n.page.delete.done
[END_COT_EXT]
==================== */

/**
 * Removes tags when removing a page
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['pages'] && cot_auth('tags', 'any', 'W'))
{
	require_once cot_incfile('tags', 'functions');
	if (cot_get_caller() == 'i18n.page')
	{
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	cot_tag_remove_all($id, 'pages', $tags_extra);
}
