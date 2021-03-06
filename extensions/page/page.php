<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Page extension main
 *
 * @package page
 * @version 0.9.3
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment setup
define('COT_PAGES', TRUE);
$env['location'] = 'pages';

// Additional API requirements
require_once cot_incfile('system', 'extrafields');

// Self requirements
require_once cot_incfile('page', 'functions');

// Mode choice
if (!in_array($m, array('add', 'edit')))
{
	if (isset($_GET['id']) || isset($_GET['al']))
	{
		$m = 'main';
	}
	else
	{
		$m = 'list';
	}
}

require_once cot_incfile('page', $m);
