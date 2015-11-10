<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.editpost.tags
Tags=
[END_COT_EXT]
==================== */

/**
 * Polls
 *
 * @package polls
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

if ($is_first_post && $usr['isadmin'] && cot_extension_active('polls') && cot_poll_edit_form($q, $t, 'MAIN.POLL', 'forum'))
{
    $t->parse('MAIN.POLL');
}
