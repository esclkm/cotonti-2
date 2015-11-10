<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Comments system for Feliz
 *
 * @package comments
 * @version 0.9.8
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'functions');

$extra_whitelist[$db_com] = array(
	'name' => $db_com,
	'caption' => 'Comments system',
	'code' => 'comments',
	'tags' => array(
		'comments.tools.tpl' => '{ADMIN_COMMENTS_XXXXX}, {ADMIN_COMMENTS_XXXXX_TITLE}',
		'comments.tpl' => '{COMMENTS_FORM_XXXXX}, {COMMENTS_FORM_XXXXX_TITLE}, {COMMENTS_ROW_XXXXX} {COMMENTS_ROW_XXXXX_TITLE}',
	)
);
