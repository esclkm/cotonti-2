<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.edit.update.done
[END_COT_EXT]
==================== */

/**
 * Hidden groups
 *
 * @package hiddengroups
 * @version 0.9.6
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

$cache && $cache->db->remove('cot_hiddenusers', 'system');
