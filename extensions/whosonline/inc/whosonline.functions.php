<?php
/**
 * Online API
 *
 * @package whosonline
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('whosonline');

cot::$db->registerTable('online');

/**
 * Checks whether user is online
 *
 * @param int $id User ID
 * @return bool
 */
function cot_userisonline($id)
{
	global $cot_usersonline;

	$res = FALSE;
	if (is_array($cot_usersonline))
	{
		$res = (in_array($id, $cot_usersonline)) ? TRUE : FALSE;
	}
	return ($res);
}
