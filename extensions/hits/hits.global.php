<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Hits counter
 *
 * @package hits
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (!defined('COT_ADMIN') && ($cfg['hits']['adminhits'] || $usr['maingrp'] != COT_GROUP_SUPERADMINS))
{
	require_once cot_incfile('hits', 'functions');

	if ($cache && $cache->mem)
	{
		$hits = $cache->mem->inc('hits', 'system');
		$cfg['hits']['hit_precision'] > 0 || $cfg['hits']['hit_precision'] = 100;
		if ($hits % $cfg['hits']['hit_precision'] == 0)
		{
			cot_stat_inc('totalpages', $cfg['hits']['hit_precision']);
			cot_stat_inc($sys['day'], $cfg['hits']['hit_precision']);
		}
	}
	else
	{
		cot_stat_inc('totalpages');
		cot_stat_update($sys['day']);
	}
}
