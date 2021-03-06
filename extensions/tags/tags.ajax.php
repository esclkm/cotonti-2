<?php
/* ====================
[BEGIN_COT_EXT]x
Hooks=ajax
[END_COT_EXT]
==================== */

/**
 * AJAX handler for autocompletion
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('tags', 'functions');
$q = mb_strtolower(cot_import('q', 'G', 'TXT'));
$q = $db->prep(urldecode($q));
if (!$q) return;

$tagslist = cot_tag_complete($q, $cfg['tags']['autocomplete']);
if (is_array($tagslist))
{
	$tagstring = implode("\n", $tagslist);
}

cot_sendheaders();
echo $tagstring;
