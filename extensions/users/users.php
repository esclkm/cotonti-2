<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Users extension main
 *
 * @package users
 * @version 0.9.4
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment
define('COT_USERS', TRUE);
$env['location'] = 'users';

require_once cot_incfile('system', 'forms');
require_once cot_incfile('system', 'uploads');

require_once cot_incfile('users');

if (!in_array($m, array('details', 'edit', 'passrecover', 'profile', 'register')))
{
	$m = 'main';
}

include cot_incfile('users', $m);
