<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.users.add.tags
[END_COT_EXT]
==================== */

/**
 * Hidden groups
 *
 * @package hiddengroups
 * @version 1.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

$hidden_groups = true;

$t->assign('ADMIN_USERS_NGRP_HIDDEN', cot_radiobox(0, 'rhidden', array(1, 0), array($L['Yes'], $L['No'])));
