<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.sections.tags
Tags=forums.sections.tpl:{FORUMS_SECTIONS_WHOSONLINE}
[END_COT_EXT]
==================== */

/**
 * Forums online users display
 *
 * @package whosonline
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$t->assign('FORUMS_SECTIONS_WHOSONLINE', $out['whosonline'] . ' : ' . $out['whosonline_reg_list']);
