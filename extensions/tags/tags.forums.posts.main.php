<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.main
[END_COT_EXT]
==================== */

/**
 * Generates keywords from topic tags
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['forums'])
{
	require_once cot_incfile('tags', 'functions');
	$tags = cot_tag_list($q, 'forums');
	$tag_keywords = implode(', ', $tags);
	$out['keywords'] = $tag_keywords;
}
