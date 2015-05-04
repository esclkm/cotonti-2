<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Standalone item translation tool
 *
 * @package i18n
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2010-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

cot_block($i18n_write);

require_once cot_incfile('system', 'forms');

if ($m == 'structure')
{
	include cot_incfile('i18n', 'structure');
}
elseif ($m == 'page')
{
	include cot_incfile('i18n', 'page');
}
else
{
	/* === Hook === */
	foreach (cot_getextensions('i18n.standalone') as $ext)
	{
		include $ext;
	}
	/* =============*/
}
