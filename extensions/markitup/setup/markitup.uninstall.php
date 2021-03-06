<?php
/**
 * markItUp! uninstall handler
 *
 * @package markitup
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (cot_extension_active('bbcode'))
{
	// Remove extensions bbcodes
	require_once cot_incfile('bbcode', 'functions');

	cot_bbcode_remove(0, 'markitup');
	cot_bbcode_clearcache();
}
