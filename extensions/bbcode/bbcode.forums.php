<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.first
[END_COT_EXT]
==================== */

/**
 * Overrides markup in Forums posts
 *
 * @package bbcode
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['parser'] == 'bbcode')
{
	$forums_quote_htmlspecialchars_bypass = true;
	$R['forums_code_quote'] = "[quote]{\$date}[url={\$url}]#{\$id}[/url] [b]{\$postername} :[/b]\n{\$text}\n[/quote]";
	$R['forums_code_update'] = "\n\n[b]{\$updated}[/b]\n\n";
}
