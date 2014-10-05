<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Forums module main
 *
 * @package forums
 * @version 0.9.3
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment
define('COT_FORUMS', true);
$env['location'] = 'forums';

// Additional requirements
require_once cot_incfile('system', 'forms');
require_once cot_incfile('system', 'extrafields');
require_once cot_incfile('users', 'functions');

// Self requirements
require_once cot_incfile('forums', 'functions');

// Mode choice
if (!in_array($m, array('topics', 'posts', 'editpost', 'newtopic')))
{
	$m = 'sections';
}

include cot_incfile('forums', 'module', $m);
