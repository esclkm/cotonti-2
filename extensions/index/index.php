<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Home page main code
 *
 * @package index
 * @version 0.9.1
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment
define('COT_INDEX', true);
$env['location'] = 'home';

/* === Hook === */
foreach (cot_getextensions('index.first') as $ext)
{
	include $ext;
}
/* ===== */

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('index', 'any');

cot_block($usr['auth_read']);

/* === Hook === */
foreach (cot_getextensions('index.main') as $ext)
{
	include $ext;
}
/* ===== */

if ($_SERVER['REQUEST_URI'] == COT_SITE_URI . 'index.php')
{
	$sys['canonical_url'] = COT_ABSOLUTE_URL;
}

require_once $cfg['system_dir'].'/header.php';

$t = new XTemplate(cot_tplfile('index'));

/* === Hook === */
foreach (cot_getextensions('index.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';

if ($cache && $usr['id'] === 0 && $cfg['cache_index'])
{
	$cache->page->write();
}
