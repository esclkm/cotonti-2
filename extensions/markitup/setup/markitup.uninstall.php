<?php
/**
 * markItUp! uninstall handler
 *
 * @package markitup
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (cot_extension_active('bbcode'))
{
	// Remove extensions bbcodes
	require_once cot_incfile('bbcode', 'module');

	cot_bbcode_remove(0, 'markitup');
	cot_bbcode_clearcache();
}
