<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */

/**
 * Users extension
 *
 * @package users
 * @version 0.9.4
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

$tt = new XTemplate(cot_tplfile('users.admin.home'));

require_once cot_incfile('users', 'functions');

$tt->parse('MAIN');

$line = $tt->text('MAIN');
