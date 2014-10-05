<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Private messages module main
 *
 * @package pm
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment setup
define('COT_PM', true);
$env['location'] = 'private_messages';

// Additional API requirements
require_once cot_incfile('system', 'forms');
require_once cot_incfile('users', 'functions');

// Self requirements
require_once cot_incfile('pm', 'functions');

// Mode choice
if (!in_array($m, array('send', 'message')))
{
	$m = 'list';
}

require_once cot_incfile('pm', $m);
