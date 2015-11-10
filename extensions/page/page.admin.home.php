<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Pages manager & Queue of pages
 *
 * @package Feliz
 * @version 0.9.4
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('page.admin.home'));

require_once cot_incfile('page', 'functions');

	$pagesqueued = $db->query("SELECT COUNT(*) FROM $db_pages WHERE page_state='1'");
	$pagesqueued = $pagesqueued->fetchColumn();
	$tt->assign(array(
		'ADMIN_HOME_URL' => cot_url('admin', 't=page'),
		'ADMIN_HOME_PAGESQUEUED' => $pagesqueued
	));

$tt->parse('MAIN');

$line = $tt->text('MAIN');
