<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

/**
 * Ratings JavaScript loader
 *
 * @package ratings
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['jquery'])
{
	cot_rc_add_file($cfg['extensions_dir'] . '/ratings/js/jquery.rating.min.js');
	cot_rc_add_file($cfg['extensions_dir'] . '/ratings/js/ratings.js');
	if($cfg['ratings']['css'])
	{
		cot_rc_add_file($cfg['extensions_dir'] . '/ratings/tpl/ratings.css');
	}
}