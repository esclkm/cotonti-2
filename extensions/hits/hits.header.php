<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Hits
 *
 * @package hits
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
if (cot_extension_active('hits') && $env['ext'] != 'admin')
{
	require_once cot_incfile('hits', 'functions');


	if ($cache && $cache->mem && $cache->mem->exists('maxusers', 'system'))
	{
		$maxusers = $cache->mem->get('maxusers', 'system');
	}
	else
	{
		$sql = $db->query("SELECT stat_value FROM $db_stats where stat_name='maxusers' LIMIT 1");
		$maxusers = (int) @$sql->fetchColumn();
		$cache && $cache->mem && $cache->mem->store('maxusers', $maxusers, 'system', 0);
	}

	if ($maxusers < $sys['whosonline_all_count'])
	{
		$sql = $db->update($db_stats, array('stat_value' => $sys['whosonline_all_count']), "stat_name='maxusers'");
	}
}
