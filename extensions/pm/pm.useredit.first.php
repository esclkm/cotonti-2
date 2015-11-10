<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.profile.update.first,users.edit.update.first
[END_COT_EXT]
==================== */

/**
 * PM user edit profile first
 *
 * @package pm
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$ruser['user_pmnotify'] = (int)cot_import('ruserpmnotify','P','BOL');
