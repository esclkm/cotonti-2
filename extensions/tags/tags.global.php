<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Tags: supplimentary files connection
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['pages']
	&& (defined('COT_INDEX') || defined('COT_LIST') || defined('COT_PAGE'))
	|| $cfg['tags']['forums'] && defined('COT_FORUMS'))
{
	require_once cot_incfile('tags', 'functions');
}
