<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.add.add.done,page.edit.update.done
[END_COT_EXT]
==================== */

/**
 * Creates alias when adding or updating a page
 *
 * @package autoalias2
 * @version 2.1.2
 * @author Trustmaster
 * @copyright (c) Feliz Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (empty($rpage['page_alias']))
{
	require_once cot_incfile('autoalias2');
	$rpage['page_alias'] = autoalias2_update($rpage['page_title'], $id);
}
