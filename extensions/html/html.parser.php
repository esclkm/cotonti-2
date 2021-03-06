<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=parser
[END_COT_EXT]
==================== */

/**
 * Connects HTML parser function
 *
 * @package bbcode
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/**
 * Enables HTML parsing of text by actually doing no changes to it
 *
 * @param string $text Page markup
 * @return string
 */
function cot_parse_html($text)
{
	return $text;
}
