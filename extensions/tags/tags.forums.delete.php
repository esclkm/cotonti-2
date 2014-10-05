<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.topics.delete.done
[END_COT_EXT]
==================== */

/**
 * Removes tags linked to a forum post
 *
 * @package tags
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['forums'] && cot_auth('tags', 'any', 'W'))
{
	require_once cot_incfile('tags', 'functions');
	cot_tag_remove_all($q, 'forums');
}
