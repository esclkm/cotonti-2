<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.newtopic.newtopic.done
[END_COT_EXT]
==================== */

/**
 * Adds tags when creating a new topic
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['forums'] && cot_auth('tags', 'any', 'W'))
{
	require_once cot_incfile('tags', 'functions');
	$item_id = $q;
	$rtags = cot_import('rtags', 'P', 'TXT');
	$tags = cot_tag_parse($rtags);
	$cnt = 0;
	foreach ($tags as $tag)
	{
		cot_tag($tag, $item_id, 'forums');
		$cnt++;
		if ($cfg['tags']['limit'] > 0 && $cnt == $cfg['tags']['limit'])
		{
			break;
		}
	}
}
