<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.list.main
[END_COT_EXT]
==================== */

/**
 * Category preload and title setup
 *
 * @package i18n
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

if ($i18n_enabled && $i18n_notmain)
{
	$cat_i18n = cot_i18n_get_cat($c, $i18n_locale);

	if ($cat_i18n)
	{
		$out['desc'] = htmlspecialchars(strip_tags($cat_i18n['desc']));
		$out['subtitle'] = $cat_i18n['title'];

		// Enable indexing
		$sys['noindex'] = false;
	}
}
